<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

// Form login
Route::get('/login', function () {
    return view('login');
})->name('login');

// Proses login
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        if (auth()->user()->role === 'admin') {
            return redirect()->intended('/admin');
        } else {
            return redirect()->intended('/dashboard');
        }
    }
    return back()->withErrors(['email' => 'Email atau password salah']);
});

// Dashboard user
Route::get('/dashboard', function () {
    if (!auth()->check() || auth()->user()->role !== 'user') {
        abort(403);
    }
    return redirect()->route('user.products.index');
})->middleware('auth');

// Dashboard admin
Route::get('/admin', function () {
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403);
    }
    return redirect()->route('admin.products.index');
})->middleware('auth');

// Daftar produk untuk user dan guest
Route::get('products', function () {
    $products = App\Models\Product::all();
    return view('user.products.index', compact('products'));
})->name('user.products.index');

// Detail produk untuk user dan guest
Route::get('products/{id}', function ($id) {
    $product = App\Models\Product::findOrFail($id);
    return view('user.products.show', compact('product'));
})->name('user.products.show');

Route::middleware(['auth'])->group(function () {
    Route::resource('admin/products', App\Http\Controllers\ProductController::class, [
        'as' => 'admin'
    ])->except(['show']);

    // Order management (admin)
    Route::get('admin/orders', function () {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403);
        }
        return app(App\Http\Controllers\TransactionController::class)->indexAdmin();
    })->name('admin.orders.index');

    // Update status order (admin)
    Route::post('admin/orders/{id}/status', [App\Http\Controllers\TransactionController::class, 'updateStatus'])->name('admin.orders.updateStatus');

    // Admin tolak permintaan pembatalan
    Route::post('admin/orders/{id}/reject-cancel', [App\Http\Controllers\TransactionController::class, 'rejectCancel'])->name('admin.orders.rejectCancel');

    // Keranjang
    Route::get('cart', [App\Http\Controllers\CartController::class, 'index'])->name('user.cart.index');
    Route::post('cart', [App\Http\Controllers\CartController::class, 'store'])->name('user.cart.store');
    Route::patch('cart/{cart}', [App\Http\Controllers\CartController::class, 'update'])->name('user.cart.update');
    Route::delete('cart/{cart}', [App\Http\Controllers\CartController::class, 'destroy'])->name('user.cart.destroy');

    // Checkout
    Route::post('checkout', [App\Http\Controllers\TransactionController::class, 'store'])->name('user.checkout');
    // Riwayat transaksi
    Route::get('transactions', [App\Http\Controllers\TransactionController::class, 'index'])->name('user.transactions.index');

    // User request cancel transaksi
    Route::post('transactions/{id}/cancel', [App\Http\Controllers\TransactionController::class, 'requestCancel'])->name('user.transactions.cancel');

    // Profil user
    Route::get('profile', function () {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    })->name('user.profile');
});

// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->middleware('auth');
