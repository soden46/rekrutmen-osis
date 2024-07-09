@extends('layouts.main')

@section('content')
    <main class="form-signin w-100 m-auto" style="max-width: 400px;">
        @include('component.alert-dismissible')

        <!-- Tambahkan Foto -->

        <!-- Pembungkus Form dengan Border -->
        <div class="border p-4 rounded">
            <form action="/authenticate" method="post">
                @csrf
                <div class="text-center mb-1 mt-0">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="max-width: 110px; height: 110px;">

                </div>
                <h1 class="h3 mb-3 fw-normal text-center">MASUK</h1>
                <div class="form-floating mb-3">
                    <label for="userName">Username</label>
                    <input type="userName" name="userName" class="form-control @error('userName') is-invalid @enderror"
                        id="userName" value="{{ old('userName') }}" autofocus required>
                    @error('userName')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password"
                        required>
                </div>

                <button class="w-100 btn btn-lg btn-primary" type="submit">MASUK</button>
                <p><a href="">Lupa Password</a></p>
            </form>
        </div>
    </main>
@endsection
