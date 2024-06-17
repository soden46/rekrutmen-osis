@extends('layouts.main')

@section('content')
<main class="form-signin w-100 m-auto" style="max-width: 400px;">
    @include('component.alert-dismissible')

    <!-- Tambahkan Foto -->
    <div class="text-center mb-4">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="max-width: 90px; height: 90px;">
    </div>

    <!-- Pembungkus Form dengan Border -->
    <div class="border p-4 rounded">
        <form action="/authenticate" method="post">
            @csrf
            <h1 class="h3 mb-3 fw-normal text-center">MASUK</h1>
            <div class="form-floating mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="email@gmail.com" value="{{ old('email') }}" autofocus required>
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit">MASUK</button>
            <p class="mt-2 mb-1 text-muted"><a href="/register">Butuh Akun?</a></p>
            <p><a href="">Lupa Password</a></p>
        </form>
    </div>
</main>
@endsection
