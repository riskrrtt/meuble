<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meuble</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
    html, body {
        height: 100%;
    }
    body {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        padding-top:56px;
    }
    main {
        flex: 1 0 auto;
    }
    .navbar.bg-white .navbar-nav .nav-link, .navbar.bg-white .navbar-brand {
        color: #222 !important;
        font-weight: 400;
    }
    .navbar.bg-white .nav-link.active, .navbar.bg-white .nav-link:focus, .navbar.bg-white .nav-link:hover {
        color: #000 !important;
    }
    .navbar.bg-white .nav-link {
        position: relative;
        transition: color 0.2s;
    }
    .navbar.bg-white .nav-link::after {
        content: '';
        display: block;
        position: absolute;
        left: 0; right: 0; bottom: 0;
        height: 2px;
        background: #222;
        transform: scaleX(0);
        transition: transform 0.2s;
    }
    .navbar.bg-white .nav-link:hover::after, .navbar.bg-white .nav-link:focus::after, .navbar.bg-white .nav-link.active::after {
        transform: scaleX(1);
    }
    </style>
</head>
<body>
    @hasSection('navbar')
        @yield('navbar')
    @else
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm" style="z-index:1040;">
        <div class="container">
            @if(!auth()->check() || (auth()->check() && auth()->user()->role === 'user'))
                <a class="navbar-brand" href="/">Meuble</a>
            @endif
            @if(auth()->check() && auth()->user()->role === 'admin')
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.products.index') }}">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.orders.index') }}">Orders</a>
                </li>
            </ul>
            @elseif(!auth()->check() || (auth()->check() && auth()->user()->role === 'user'))
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.products.index') }}">Produk</a>
                </li>
            </ul>
            @endif
            <div class="collapse navbar-collapse">
                @if(auth()->check() && auth()->user()->role === 'admin')
                <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <form action="/logout" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link" style="padding:0;">Logout</button>
                            </form>
                        </li>
                    </ul>
                @else
                    <ul class="navbar-nav ms-auto">
                        @auth
                            @if(auth()->user()->role === 'user')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ auth()->check() ? route('user.profile') : route('login') }}" title="Profil">
                                    <!-- User Icon Feather/Lucide -->
                                    <svg width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                </a>
                            </li>
                        <li class="nav-item">
                                <a class="nav-link" href="{{ auth()->check() ? route('user.cart.index') : route('login') }}" title="Keranjang">
                                    <!-- Cart Icon Feather/Lucide -->
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            </a>
                        </li>
                        <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.transactions.index') }}" title="Riwayat Transaksi">
                                    <!-- Clock Icon Feather/Lucide -->
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                      <circle cx="12" cy="12" r="10"/>
                                      <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                            </a>
                        </li>
                        @endif
                        {{-- Logout dipindahkan ke halaman profil --}}
                    @else
                            @if(!request()->routeIs('login') && !request()->routeIs('register'))
                        <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                            @endif
                    @endauth
                </ul>
                @endif
            </div>
        </div>
    </nav>
    @endif
    <main>
        @yield('content')
    </main>
    @if(!auth()->check() || (auth()->check() && auth()->user()->role === 'user'))
    <footer class="bg-light text-center py-4 mt-5 border-top" style="font-size:1rem; flex-shrink:0;">
        <div>Hubungi kami:</div>
        <div>📞 0895-0174-9516</div>
        <div>📷 <a href="https://instagram.com/seoniarsfurniture" target="_blank" rel="noopener" style="color:#222;text-decoration:underline;">@seoniarsfurniture</a></div>
        <div>🏠 Jl. Raya Jepara No. 27, Kota Jepara</div>
    </footer>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 