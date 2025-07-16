@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width:480px;">
    <h5 class="mb-4 fw-light">Edit Produk</h5>
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-2">
            <label for="name" class="form-label small">Nama Produk</label>
            <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ $product->name }}" required>
        </div>
        <div class="mb-2">
            <label for="description" class="form-label small">Deskripsi</label>
            <textarea class="form-control form-control-sm" id="description" name="description" required rows="2">{{ $product->description }}</textarea>
        </div>
        <div class="mb-2">
            <label for="price" class="form-label small">Harga</label>
            <input type="number" class="form-control form-control-sm" id="price" name="price" value="{{ $product->price }}" required>
        </div>
        <div class="mb-2">
            <label for="stock" class="form-label small">Stok</label>
            <input type="number" class="form-control form-control-sm" id="stock" name="stock" value="{{ $product->stock }}" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label small">Link Gambar (opsional)</label>
            <input type="url" class="form-control form-control-sm" id="image" name="image" value="{{ $product->image }}" placeholder="https://...">
            @if($product->image)
                <img src="{{ $product->image }}" width="64" class="mt-2 rounded" style="border-radius:6px;">
            @endif
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-outline-success btn-sm">Update</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
        </div>
    </form>
</div>
@endsection 