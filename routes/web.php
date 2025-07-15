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
            return redirect()->route('welcome')->with('success', 'Selamat datang, ' . auth()->user()->name . '!');
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
    $q = request('q');
    $products = \App\Models\Product::query();
    if ($q) {
        $products->where('name', 'like', '%' . $q . '%');
    }
    $products = $products->get();
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
        if ($user->role === 'admin') {
            return redirect()->route('admin.products.index');
        }
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

Route::post('/profile/update', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'first_name' => ['required', 'string', 'min:2', 'max:30', 'regex:/^[A-Za-z\s]+$/u'],
        'last_name' => ['nullable', 'string', 'max:30', 'regex:/^[A-Za-z\s]*$/u'],
    ], [
        'first_name.required' => 'Nama depan wajib diisi.',
        'first_name.min' => 'Nama depan minimal 2 karakter.',
        'first_name.max' => 'Nama depan maksimal 30 karakter.',
        'first_name.regex' => 'Nama depan hanya boleh huruf dan spasi.',
        'last_name.max' => 'Nama belakang maksimal 30 karakter.',
        'last_name.regex' => 'Nama belakang hanya boleh huruf dan spasi.',
    ]);
    $user = auth()->user();
    $user->name = trim($request->first_name . ' ' . $request->last_name);
    $user->save();
    return redirect()->route('user.profile')->with('success', 'Nama berhasil diperbarui!');
})->middleware('auth');

// Form register
Route::get('/register', function () {
    if (auth()->check()) return redirect('/');
    return view('register');
})->name('register');

// Proses register
Route::post('/register', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'first_name' => ['required', 'string', 'min:2', 'max:30', 'regex:/^[A-Za-z\s]+$/u'],
        'last_name' => ['nullable', 'string', 'max:30', 'regex:/^[A-Za-z\s]*$/u'],
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
    ], [
        'first_name.required' => 'Nama depan wajib diisi.',
        'first_name.min' => 'Nama depan minimal 2 karakter.',
        'first_name.max' => 'Nama depan maksimal 30 karakter.',
        'first_name.regex' => 'Nama depan hanya boleh huruf dan spasi.',
        'last_name.max' => 'Nama belakang maksimal 30 karakter.',
        'last_name.regex' => 'Nama belakang hanya boleh huruf dan spasi.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah terdaftar.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 6 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
    ]);
    $user = new \App\Models\User();
    $user->name = trim($request->first_name . ' ' . $request->last_name);
    $user->email = $request->email;
    $user->password = bcrypt($request->password);
    $user->role = 'user';
    $user->save();
    Auth::login($user);
    return redirect()->route('welcome')->with('success', 'Selamat datang, ' . $user->name . '!');
});

// Route untuk welcome agar bisa di-redirect
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');
