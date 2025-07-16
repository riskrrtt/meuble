@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width:480px;">
    <h5 class="mb-4 fw-light">Tambah Produk</h5>
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-2">
            <label for="name" class="form-label small">Nama Produk</label>
            <input type="text" class="form-control form-control-sm" id="name" name="name" required>
        </div>
        <div class="mb-2">
            <label for="description" class="form-label small">Deskripsi</label>
            <textarea class="form-control form-control-sm" id="description" name="description" required rows="2"></textarea>
        </div>
        <div class="mb-2">
            <label for="price" class="form-label small">Harga</label>
            <input type="number" class="form-control form-control-sm" id="price" name="price" required>
        </div>
        <div class="mb-2">
            <label for="stock" class="form-label small">Stok</label>
            <input type="number" class="form-control form-control-sm" id="stock" name="stock" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label small">Link Gambar (opsional)</label>
            <input type="url" class="form-control form-control-sm" id="image" name="image" placeholder="https://...">
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-outline-success btn-sm">Simpan</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
        </div>
    </form>
</div>
@endsection 