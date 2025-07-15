@extends('layouts.app')

@section('content')
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <h2>Profil Saya</h2>
    <div class="card" style="max-width:400px;">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label mb-1" style="font-weight:600;">Nama</label>
                <div class="d-flex align-items-center gap-2">
                    <span style="font-size:1.1rem;">{{ $user->name }}</span>
                    @if(auth()->user()->role === 'user')
                    <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#editNameModal" title="Edit Nama">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19.5 3 21l1.5-4L16.5 3.5z"/></svg>
                    </button>
                    @endif
                </div>
            </div>
            <div class="mb-2">
                <label class="form-label mb-1" style="font-weight:600;">Email</label>
                <div style="font-size:1.1rem; color:#555;">{{ $user->email }}</div>
            </div>
        </div>
        <div class="card-footer bg-white border-0 d-flex flex-column gap-2">
            <form action="/logout" method="POST" onsubmit="event.preventDefault(); document.getElementById('logout-form').submit();">
                @csrf
                <button class="btn btn-danger w-100" type="submit">Logout</button>
            </form>
            <form id="logout-form" action="/logout" method="POST" style="display:none">
                @csrf
                <input type="hidden" name="redirect" value="/">
            </form>
        </div>
    </div>
</div>

@if(auth()->user()->role === 'user')
<!-- Modal Edit Nama -->
<div class="modal fade" id="editNameModal" tabindex="-1" aria-labelledby="editNameModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="/profile/update" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="editNameModalLabel">Edit Profil</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="row mb-3">
            <div class="col">
              <input type="text" class="form-control" name="first_name" placeholder="Nama depan" value="{{ explode(' ', $user->name)[0] ?? '' }}" required>
            </div>
            <div class="col">
              <input type="text" class="form-control" name="last_name" placeholder="Nama belakang" value="{{ implode(' ', array_slice(explode(' ', $user->name), 1)) }}">
            </div>
          </div>
          <input type="email" class="form-control mb-2" value="{{ $user->email }}" readonly>
          <small class="text-muted">Email digunakan untuk login dan tidak dapat diubah</small>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endif
@endsection 