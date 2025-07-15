@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Kelola Order</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Total</th>
                <th>Detail Produk</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $trx)
            <tr>
                <td>{{ $trx->id }}</td>
                <td>{{ $trx->user->email ?? '-' }}</td>
                <td>{{ $trx->created_at->format('d-m-Y H:i') }}</td>
                <td>
                    <form action="{{ route('admin.orders.updateStatus', $trx->id) }}" method="POST" class="d-flex align-items-center gap-2">
                        @csrf
                        <select name="status" class="form-select form-select-sm" style="width:auto">
                            <option value="pending" {{ $trx->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diproses" {{ $trx->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="dikirim" {{ $trx->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="selesai" {{ $trx->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ $trx->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        <button class="btn btn-sm btn-primary" type="submit">Update</button>
                    </form>
                </td>
                <td>IDR {{ number_format($trx->total,0,',','.') }}</td>
                <td>
                    <ul>
                        @php $items = is_array($trx->items) ? $trx->items : json_decode($trx->items, true); @endphp
                        @foreach($items as $item)
                        <li>{{ $item['name'] }} ({{ $item['quantity'] }} x IDR {{ number_format($item['price'],0,',','.') }})</li>
                        @endforeach
                    </ul>
                    @if($trx->cancel_requested && $trx->status !== 'dibatalkan')
                        <span class="badge bg-warning text-dark mt-2">Permintaan Pembatalan</span>
                        <form action="{{ route('admin.orders.updateStatus', $trx->id) }}" method="POST" class="d-inline ms-2">
                            @csrf
                            <input type="hidden" name="status" value="dibatalkan">
                            <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Setujui pembatalan pesanan ini?')">Setujui</button>
                        </form>
                        <form action="{{ route('admin.orders.rejectCancel', $trx->id) }}" method="POST" class="d-inline ms-1">
                            @csrf
                            <button class="btn btn-sm btn-secondary" type="submit">Tolak</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 