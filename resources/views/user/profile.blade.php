@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Profil Saya</h2>
    <div class="card" style="max-width:400px;">
        <div class="card-body">
            <p class="mb-2"><strong>Email:</strong></p>
            <div class="alert alert-light">{{ $user->email }}</div>
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
@endsection 