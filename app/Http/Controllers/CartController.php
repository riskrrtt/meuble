<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Tampilkan isi keranjang user
    public function index()
    {
        $carts = Cart::with('product')->where('user_id', Auth::id())->get();
        return view('user.cart', compact('carts'));
    }

    // Tambah produk ke keranjang
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $product = Product::findOrFail($request->product_id);
        if ($product->stock < $request->quantity || $product->stock < 1) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi!');
        }
        $cart = Cart::firstOrNew([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
        ]);
        $cart->quantity += $request->quantity;
        $cart->save();
        // Jika ada referer dari detail produk, redirect back, jika tidak ke cart
        $referer = $request->headers->get('referer');
        if ($referer && str_contains($referer, '/products/')) {
            return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
        }
        return redirect()->route('user.cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // Update qty produk di keranjang
    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        $cart->update(['quantity' => $request->quantity]);
        return redirect()->route('user.cart.index')->with('success', 'Jumlah produk diperbarui');
    }

    // Hapus produk dari keranjang
    public function destroy(Cart $cart)
    {
        $cart->delete();
        return redirect()->route('user.cart.index')->with('success', 'Produk dihapus dari keranjang');
    }
}
