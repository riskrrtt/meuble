@extends('layouts.app')

@section('content')
<style>
.hero-bg {
    position: relative;
    background: url('https://images.unsplash.com/photo-1653928069878-32e246258e8e?q=80&w=1932&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') center/cover no-repeat;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.hero-bg::before {
    content: "";
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.2); 
    z-index: 1;
}
.hero-bg > * {
    position: relative;
    z-index: 2;
}
.hero-overlay {
    background: rgba(255,255,255,0.7);
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
}
.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
}
.hero-title {
    font-size: 2.5rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    color: #fff;
    margin-bottom: 2rem;
    text-transform: uppercase;
    text-shadow: 0 2px 8px rgba(0,0,0,0.25);
}
.hero-content, .hero-content * {
    color: #fff !important;
}
.hero-content a.btn {
    border-color: #fff;
    color: #fff !important;
    background: rgba(0,0,0,0.15);
}
.hero-content a.btn:hover {
    background: #fff;
    color: #222 !important;
}
@media (min-width: 768px) {
    .hero-title { font-size: 3.5rem; }
}
body, html { height: 100%; margin: 0; padding: 0; }
</style>
<div class="hero-bg">
    <div class="hero-content w-100">
        <div class="hero-title">SEONIARS COLLECTION</div>
        <a href="{{ route('user.products.index') }}" class="btn btn-outline-dark btn-lg">Belanja Sekarang</a>
    </div>
</div>
@endsection