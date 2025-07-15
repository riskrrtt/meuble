@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Keranjang Belanja</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(count($carts) === 0)
        <div class="text-center text-muted my-5" style="font-size:1.2rem;">Keranjang anda kosong</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($carts as $cart)
                @php $subtotal = $cart->product->price * $cart->quantity; $total += $subtotal; @endphp
                <tr>
                    <td>{{ $cart->product->name }}</td>
                    <td>IDR {{ number_format($cart->product->price, 0, ',', '.') }}</td>
                    <td>
                        <form action="{{ route('user.cart.update', $cart) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <div class="d-flex align-items-center" style="gap:8px;">
                                <div class="input-group" style="max-width:120px;">
                                    <button type="button" class="btn btn-outline-secondary" onclick="var qty=document.getElementById('qty-{{ $cart->id }}');if(qty.value>1)qty.value--">-</button>
                                    <input type="number" name="quantity" id="qty-{{ $cart->id }}" value="{{ $cart->quantity }}" min="1" max="{{ $cart->product->stock }}" class="form-control text-center" style="width:50px;">
                                    <button type="button" class="btn btn-outline-secondary" onclick="var qty=document.getElementById('qty-{{ $cart->id }}');if(qty.value<{{ $cart->product->stock }})qty.value++">+</button>
                                </div>
                                <button class="btn btn-sm btn-info" type="submit">Update</button>
                            </div>
                        </form>
                    </td>
                    <td>IDR {{ number_format($subtotal,0,',','.') }}</td>
                    <td>
                        <form action="{{ route('user.cart.destroy', $cart) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Hapus produk dari keranjang?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total</th>
                    <th colspan="2">IDR {{ number_format($total,0,',','.') }}</th>
                </tr>
            </tfoot>
        </table>
        <form action="{{ route('user.checkout') }}" method="POST">
            @csrf
            <button class="btn btn-success" type="submit" {{ $total == 0 ? 'disabled' : '' }}>Checkout</button>
        </form>
    @endif
</div>
@endsection 

<style>
input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
input[type=number] {
    -moz-appearance: textfield;
}
</style> 