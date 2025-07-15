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
    @if(session('success'))
        <div id="welcome-alert" class="alert alert-success text-center" style="position:fixed;top:30px;left:50%;transform:translateX(-50%);z-index:2000;max-width:500px;">{{ session('success') }}</div>
        <script>
            setTimeout(function() {
                var alert = document.getElementById('welcome-alert');
                if(alert) alert.style.display = 'none';
            }, 3000);
        </script>
    @endif
    <div class="hero-content w-100">
        <div class="hero-title">SEONIARS COLLECTION</div>
        <a href="{{ route('user.products.index') }}" class="btn btn-outline-dark btn-lg">Belanja Sekarang</a>
    </div>
</div>
<!-- Section Classic Meets Modern -->
<div class="container my-5" style="margin-top:64px; margin-bottom:64px;">
    <div class="text-center mb-2" style="letter-spacing:0.22em;font-size:2.3rem;font-family:'Montserrat',Arial,sans-serif;font-weight:400;color:#444;">MEUBLE JEPARA</div>
    <div class="text-center mb-4" style="font-size:1.1rem;color:#888;font-family:'Montserrat',Arial,sans-serif;letter-spacing:0.08em;">Klasik & Modern, Kualitas Asli Jepara</div>
    <hr style="width:120px;margin:24px auto 40px auto;border-top:2px solid #ccc;opacity:0.3;">
    <div class="row justify-content-center gy-5 gx-5">
        <div class="col-md-4 col-12">
            <h4 class="mb-3" style="letter-spacing:0.13em;font-weight:400;font-family:'Montserrat',Arial,sans-serif;color:#666;">KEABADIAN</h4>
            <p style="color:#888;font-size:1.05rem;line-height:1.7;font-family:'Montserrat',Arial,sans-serif;">Meuble kami berasal dari Jepara, pusat kerajinan kayu terbaik di Indonesia. Setiap produk dirancang agar tetap indah dan relevan sepanjang masa, mudah dipadukan dengan berbagai gaya dan tren rumah.</p>
        </div>
        <div class="col-md-4 col-12">
            <h4 class="mb-3" style="letter-spacing:0.13em;font-weight:400;font-family:'Montserrat',Arial,sans-serif;color:#666;">KUALITAS</h4>
            <p style="color:#888;font-size:1.05rem;line-height:1.7;font-family:'Montserrat',Arial,sans-serif;">Kami hanya menggunakan material berkualitas tinggi dan dikerjakan oleh pengrajin berpengalaman dari Jepara. Hasilnya adalah produk yang tidak hanya menarik secara visual, tapi juga awet dan tahan lama.</p>
        </div>
        <div class="col-md-4 col-12">
            <h4 class="mb-3" style="letter-spacing:0.13em;font-weight:400;font-family:'Montserrat',Arial,sans-serif;color:#666;">PERAWATAN</h4>
            <p style="color:#888;font-size:1.05rem;line-height:1.7;font-family:'Montserrat',Arial,sans-serif;">Agar keindahan meuble Jepara tetap terjaga, ikuti tips perawatan sederhana dari kami. Dengan perawatan yang tepat, produk akan tetap cantik dan fungsional selama bertahun-tahun.</p>
        </div>
    </div>
</div>

<hr style="width:100%;border-top:2px solid #ccc;opacity:0.2;margin:0 0 64px 0;">

<!-- Section About -->
<div class="container my-5" style="margin-top:64px; margin-bottom:64px;">
    <div class="about-flex-section" style="display:flex; justify-content:center; align-items:center; gap:48px; flex-wrap:wrap; min-height:380px;">
        <div style="flex:0 0 320px; display:flex; justify-content:center;">
            <img src="https://i.pinimg.com/1200x/34/c3/16/34c31617abd0283199d8a7cc1fc6ce43.jpg" alt="About" style="width:320px; height:360px; object-fit:cover; border-radius:14px; box-shadow:0 4px 24px rgba(0,0,0,0.08);">
        </div>
        <div style="flex:1 1 340px; min-width:280px; max-width:520px; display:flex; flex-direction:column; justify-content:center;">
            <div style="font-family:'Montserrat',Arial,sans-serif;">
                <div style="letter-spacing:0.18em; color:#888; font-size:1.05rem; margin-bottom:12px;">TENTANG</div>
                <div style="color:#888;font-size:1.05rem;line-height:1.7;">
                    Meublé adalah brand interior dari Jepara yang memadukan desain klasik dengan sentuhan kontemporer. Menggunakan material alami pilihan, desain kami yang abadi akan memperindah ruangan Anda sepanjang masa.
                </div>
            </div>
        </div>
    </div>
</div>

<hr style="width:100%;border-top:2px solid #ccc;opacity:0.2;margin:0 0 64px 0;">

<style>
@media (max-width: 900px) {
  .about-flex-section {
    flex-direction: column !important;
    gap: 28px !important;
    min-height: unset !important;
  }
  .about-flex-section > div {
    max-width: 100% !important;
  }
  .about-flex-section img {
    width: 90vw !important;
    max-width: 340px !important;
    height: auto !important;
  }
}
</style>
@endsection