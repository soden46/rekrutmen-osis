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
                    <img src="{{ asset('assets/img/rekrutmen.png') }}" alt="Logo" style="max-width: 110px; height: 110px;">
                </div>
                <h1 class="h3 mb-3 fw-normal text-center">MASUK</h1>
                <div class="form-floating mb-3">
                    <label for="userName">NIP/NIS</label>
                    <input type="userName" name="userName" class="form-control @error('userName') is-invalid @enderror"
                        id="userName" value="{{ old('userName') }}" autofocus required>
                    @error('userName')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-floating">
                    <label for="floatingPassword">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" placeholder="Password" required>
                        <div class="input-group-append" style="height: 38px">
                            <span class="input-group-text" onclick="password_show_hide();"
                                style="border: true; background: none;">
                                <i class="fas fa-eye" id="show_eye"></i>
                                <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                            </span>
                        </div>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <button class="w-100 btn btn-lg btn-primary" type="submit">MASUK</button>
                {{-- <p><a href="">Lupa Password</a></p> --}}
            </form>
        </div>
    </main>
    <script>
        function password_show_hide() {
            var x = document.getElementById("password");
            var show_eye = document.getElementById("show_eye");
            var hide_eye = document.getElementById("hide_eye");
            hide_eye.classList.remove("d-none");
            if (x.type === "password") {
                x.type = "text";
                show_eye.style.display = "none";
                hide_eye.style.display = "block";
            } else {
                x.type = "password";
                show_eye.style.display = "block";
                hide_eye.style.display = "none";
            }
        }
    </script>
@endsection
