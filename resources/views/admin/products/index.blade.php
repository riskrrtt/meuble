@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="mb-4 fw-light" style="letter-spacing:0.5px;">Daftar Produk</h4>
    @if(session('success'))
        <div class="alert alert-success small">{{ session('success') }}</div>
    @endif
    <a href="{{ route('admin.products.create') }}" class="btn btn-outline-primary btn-sm mb-3">+ Tambah Produk</a>
    <div class="table-responsive">
    <table class="table table-sm table-borderless align-middle" style="font-size:15px;">
        <thead class="border-bottom">
            <tr class="text-secondary">
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td class="text-muted" style="max-width:200px;">{{ $product->description }}</td>
                <td>IDR {{ number_format($product->price, 0, ',', '.') }}</td>
                <td>{{ $product->stock }}</td>
                <td>
                    @if($product->image)
                        <img src="{{ $product->image }}" width="48" style="border-radius:6px;">
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-warning btn-sm me-1">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin hapus produk?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection 