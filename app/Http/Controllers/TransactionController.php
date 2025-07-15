<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // Proses checkout
    public function store(Request $request)
    {
        // Jika checkout langsung dari detail produk
        if ($request->has(['product_id', 'quantity'])) {
            $product = \App\Models\Product::findOrFail($request->product_id);
            $qty = (int) $request->quantity;
            if ($qty < 1 || $product->stock < $qty) {
                return redirect()->back()->with('error', 'Stok produk tidak mencukupi!');
            }
            $items = [[
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $qty,
            ]];
            $total = $product->price * $qty;
            $product->decrement('stock', $qty);
            $transaction = Transaction::create([
                'user_id' => \Auth::id(),
                'total' => $total,
                'status' => 'pending',
                'items' => json_encode($items),
            ]);
            return redirect()->route('user.transactions.index')->with('success', 'Checkout berhasil!');
        }
        // Checkout semua isi cart (default)
        $carts = Cart::with('product')->where('user_id', Auth::id())->get();
        if ($carts->isEmpty()) {
            return redirect()->route('user.cart.index')->with('success', 'Keranjang kosong!');
        }
        $items = [];
        $total = 0;
        foreach ($carts as $cart) {
            if ($cart->quantity > $cart->product->stock) {
                return redirect()->route('user.cart.index')->with('success', 'Stok produk tidak cukup: ' . $cart->product->name);
            }
            $items[] = [
                'product_id' => $cart->product->id,
                'name' => $cart->product->name,
                'price' => $cart->product->price,
                'quantity' => $cart->quantity,
            ];
            $total += $cart->product->price * $cart->quantity;
            // Kurangi stok
            $cart->product->decrement('stock', $cart->quantity);
        }
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'status' => 'pending',
            'items' => json_encode($items),
        ]);
        // Hapus keranjang
        Cart::where('user_id', Auth::id())->delete();
        return redirect()->route('user.transactions.index')->with('success', 'Checkout berhasil!');
    }

    // Riwayat transaksi user
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())->get();
        return view('user.transactions.index', compact('transactions'));
    }

    // Daftar semua transaksi untuk admin
    public function indexAdmin()
    {
        $transactions = Transaction::with('user')->orderByDesc('created_at')->get();
        return view('admin.transactions.index', compact('transactions'));
    }

    // Update status pesanan (admin)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,dikirim,selesai,dibatalkan',
        ]);
        $trx = Transaction::findOrFail($id);
        $oldStatus = $trx->status;
        $trx->status = $request->status;
        $trx->save();
        // Jika status berubah ke dibatalkan dan sebelumnya bukan dibatalkan, kembalikan stok
        if ($oldStatus !== 'dibatalkan' && $request->status === 'dibatalkan') {
            $items = is_array($trx->items) ? $trx->items : json_decode($trx->items, true);
            foreach ($items as $item) {
                $product = \App\Models\Product::find($item['product_id']);
                if ($product) {
                    $product->increment('stock', $item['quantity']);
                }
            }
        }
        return redirect()->route('admin.orders.index')->with('success', 'Status pesanan diperbarui');
    }

    // User request cancel transaksi
    public function requestCancel($id)
    {
        $trx = Transaction::where('id', $id)->where('user_id', \Auth::id())->firstOrFail();
        if ($trx->status !== 'dibatalkan' && !$trx->cancel_requested) {
            $trx->cancel_requested = true;
            $trx->save();
            return redirect()->route('user.transactions.index')->with('success', 'Permintaan pembatalan dikirim, menunggu persetujuan admin.');
        }
        return redirect()->route('user.transactions.index');
    }

    // Admin tolak permintaan pembatalan
    public function rejectCancel($id)
    {
        $trx = Transaction::findOrFail($id);
        if ($trx->cancel_requested && $trx->status !== 'dibatalkan') {
            $trx->cancel_requested = false;
            $trx->save();
        }
        return redirect()->route('admin.orders.index')->with('success', 'Permintaan pembatalan ditolak.');
    }
}
