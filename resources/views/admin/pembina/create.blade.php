@extends('dashboard', [
    'title' => 'Tambah Pembina',
    'pageTitle' => 'Tambah Pembina',
])
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Tambah Pembina</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.pembina.save') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="nip">NIP</label>
                        <input type="text" class="form-control" id="nip" name="nip">
                    </div>
                    <div class="form-floating">
                        <label for="floatingInput">Nama</label>
                        <input type="text" name="nama" class="form-control @error('nama')is-invalid @enderror"
                            id="floatingInput" placeholder="nama Lengkap" required value="{{ old('nama') }}">
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Pilih Jenis Kelamin</label>
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-floating">
                        <label for="floatingPassword">Password</label>
                        <div class="input-group">
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" id="password"
                                placeholder="Password" required>
                            <div class="input-group-append" style="height: 55px">
                                <span class="input-group-text" onclick="password_show_hide();"
                                    style="border: none; background: none;">
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

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </form>
            </div>
        </div>
    </div>
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
