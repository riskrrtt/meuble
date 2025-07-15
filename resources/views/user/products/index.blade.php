@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <h2 class="mb-5 text-center" style="font-weight:400;letter-spacing:0.05em;">PRODUK</h2>
    <form method="GET" action="" class="mb-4" style="max-width:400px;margin:0 auto;">
        <div class="input-group">
            <input type="text" class="form-control" name="q" placeholder="Cari produk..." value="{{ request('q') }}">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </div>
    </form>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-5">
        @foreach($products as $product)
        <div class="col">
            <div class="card border-0 bg-transparent text-center h-100 mb-4">
                <a href="{{ route('user.products.show', $product->id) }}" style="text-decoration:none;">
                    @if($product->image)
                        <img src="{{ $product->image }}" class="card-img-top mb-3" style="height:200px;object-fit:cover;box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                    @else
                        <div style="height:200px;background:#f5f5f5;"></div>
                    @endif
                </a>
                <div class="card-body p-0">
                    <a href="{{ route('user.products.show', $product->id) }}" style="text-decoration:none;color:#444;font-weight:600;letter-spacing:0.05em;font-size:1.1rem;display:block;">
                        {{ strtoupper($product->name) }}
                    </a>
                    <div style="color:#888;font-size:1rem;margin-top:0.5rem;letter-spacing:0.05em;">
                        IDR {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection 