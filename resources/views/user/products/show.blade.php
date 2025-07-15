@extends('layouts.app')

@section('content')
<style>
/* Hilangkan spinner input number di semua browser */
input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
input[type=number] {
    -moz-appearance: textfield;
}
</style>
<div class="container mt-5">
    <div class="row justify-content-center align-items-center">
        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif
        <div class="col-md-6 text-center mb-4 mb-md-0">
            @if($product->image)
                <img src="{{ $product->image }}" class="img-fluid" style="max-height:400px;object-fit:contain;">
            @endif
        </div>
        <div class="col-md-6">
            @if($product->stock < 1)
                <span class="badge bg-danger mb-2" style="font-size:1rem;">Stok Habis</span>
            @endif
            <h2 class="mb-2" style="font-weight:700;letter-spacing:0.05em;">{{ strtoupper($product->name) }}</h2>
            <div class="mb-3" style="color:#888;font-size:1.5rem;">IDR {{ number_format($product->price, 0, ',', '.') }}</div>
            <hr>
            <div class="mb-3" style="font-size:1.1rem;">{!! nl2br(e($product->description)) !!}</div>
            <div class="mb-3">Stok: {{ $product->stock }}</div>
            <form action="{{ route('user.cart.store') }}" method="POST" class="mb-3 d-flex align-items-center gap-2" style="max-width:220px;">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="button" class="btn btn-outline-secondary" onclick="var qty=document.getElementById('qty');if(qty.value>1)qty.value--" @if($product->stock < 1) disabled @endif>-</button>
                <input type="number" id="qty" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control text-center" style="width:60px;" @if($product->stock < 1) disabled @endif>
                <button type="button" class="btn btn-outline-secondary" onclick="var qty=document.getElementById('qty');if(qty.value<{{ $product->stock }})qty.value++" @if($product->stock < 1) disabled @endif>+</button>
            </form>
            <div class="d-flex flex-column gap-2" style="max-width:350px;">
                <form action="{{ route('user.cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" id="qty2" value="1">
                    <button type="submit" class="btn btn-outline-dark w-100" onclick="document.getElementById('qty2').value=document.getElementById('qty').value;" @if($product->stock < 1) disabled @endif>Tambah ke Keranjang</button>
                </form>
                <form action="{{ route('user.checkout') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" id="qty3" value="1">
                    <button type="submit" class="btn btn-dark w-100" onclick="document.getElementById('qty3').value=document.getElementById('qty').value;" @if($product->stock < 1) disabled @endif>Beli Sekarang</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 