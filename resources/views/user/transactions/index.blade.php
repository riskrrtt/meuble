@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Riwayat Transaksi</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(count($transactions) === 0)
        <div class="text-center text-muted my-5" style="font-size:1.2rem;">Belum ada transaksi</div>
    @else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Total</th>
                <th>Detail Produk</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $trx)
            <tr>
                <td>{{ $trx->id }}</td>
                <td>{{ $trx->created_at->format('d-m-Y H:i') }}</td>
                <td>{{ ucfirst($trx->status) }}</td>
                <td>IDR {{ number_format($trx->total,0,',','.') }}</td>
                <td>
                    <ul>
                        @php $items = is_array($trx->items) ? $trx->items : json_decode($trx->items, true); @endphp
                        @foreach($items as $item)
                        <li>{{ $item['name'] }} ({{ $item['quantity'] }} x IDR {{ number_format($item['price'],0,',','.') }})</li>
                        @endforeach
                    </ul>
                </td>
                <td class="text-center">
                    @if($trx->status !== 'dibatalkan')
                        @if(!$trx->cancel_requested)
                        <form action="{{ route('user.transactions.cancel', $trx->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">Batalkan</button>
                        </form>
                        @else
                        <span class="badge bg-warning text-dark">Menunggu Persetujuan Admin</span>
                        @endif
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection 