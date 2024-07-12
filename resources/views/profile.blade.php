@extends('dashboard', [
    'title' => 'Edit Profile',
    'pageTitle' => 'Edit Profile',
])
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    Email : {{ Auth::user()->email }}
                </div>
                <div class="card-body">
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row no-gutters">
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{ Auth::user()->name }}</h5>
                                    <p class="card-text">
                                        <small
                                            class="text-muted">{{ 'updated at ' . \Carbon\Carbon::parse(Auth::user()->updated_at)->diffForHumans() }}</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    Edit Profile
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update', Auth::user()->id) }}">
                        @csrf
                        @method('PUT')
                        @if (Auth::user()->role == 'siswa')
                            <input required value="{{ $siswa->users->id }}" class="form-control" type="text"
                                id="id_user" name="id_user" hidden>
                            <div class="form-group">
                                <label for="nis">NIS</label>
                                <input required value="{{ $siswa->nis }}" class="form-control" type="number"
                                    id="nis" name="nis">
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama Lengkap</label>
                                <input required value="{{ $siswa->users->nama }}" class="form-control" type="text"
                                    id="nama" name="nama">
                            </div>
                            <div class="form-group">
                                <label for="nis">NIS</label>
                                <input required value="{{ $siswa->nis }}" class="form-control" type="text"
                                    id="nis" name="nis">
                            </div>
                            <div class="form-group">
                                <label for="kelas">Kelas</label>
                                <input required value="{{ $siswa->kelas }}" class="form-control" type="text"
                                    id="kelas" name="kelas">
                            </div>
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input required value="{{ $siswa->tempat_lahir }}" class="form-control" type="area"
                                    id="tempat_lahir" name="tempat_lahir">
                            </div>
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input required value="{{ $siswa->tanggal_lahir }}" class="form-control" type="date"
                                    id="tanggal_lahir" name="tanggal_lahir">
                            </div>
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-Laki" {{ $siswa->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' }}>
                                        Laki-Laki</option>
                                    <option value="Perempuan" {{ $siswa->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                            </div>
                            <div class="form-floating">
                                <label for="floatingPassword">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror" id="password"
                                        placeholder="Password" name="password" required>
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
                            <div class="form-floating">
                                <label for="password_confirmation">Ulangi Password</label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        id="password_confirmation" placeholder="Ulangi Password" required>
                                    <div class="input-group-append" style="height: 38px">
                                        <span class="input-group-text" onclick="password_confirmation_show_hide();"
                                            style="border: true; background: none;">
                                            <i class="fas fa-eye" id="show_confirmation_eye"></i>
                                            <i class="fas fa-eye-slash d-none" id="hide_confirmation_eye"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        @elseif(Auth::user()->role == 'admin')
                            <input required value="{{ $admin->users->id }}" class="form-control" type="text"
                                id="id_user" name="id_user" hidden>
                            <div class="form-group">
                                <label for="nip">NIP</label>
                                <input required value="{{ $admin->nip }}" class="form-control" type="number"
                                    id="nip" name="nip">
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama Lengkap</label>
                                <input required value="{{ $admin->users->nama }}" class="form-control" type="text"
                                    id="nama" name="nama">
                            </div>
                            <div class="form-group">
                                <label for="nip">NIP</label>
                                <input required value="{{ $admin->nip }}" class="form-control" type="text"
                                    id="nip" name="nip">
                            </div>
                            <div class="form-group">
                                <label for="kelas">Kelas</label>
                                <input required value="{{ $admin->kelas }}" class="form-control" type="text"
                                    id="kelas" name="kelas">
                            </div>
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input required value="{{ $admin->tempat_lahir }}" class="form-control" type="area"
                                    id="tempat_lahir" name="tempat_lahir">
                            </div>
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input required value="{{ $admin->tanggal_lahir }}" class="form-control" type="date"
                                    id="tanggal_lahir" name="tanggal_lahir">
                            </div>
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-Laki"
                                        {{ $admin->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' }}>
                                        Laki-Laki</option>
                                    <option value="Perempuan"
                                        {{ $admin->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                            </div>
                            <div class="form-floating">
                                <label for="floatingPassword">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror" id="password"
                                        placeholder="Password" name="password" required>
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
                            <div class="form-floating">
                                <label for="password_confirmation">Ulangi Password</label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        id="password_confirmation" placeholder="Ulangi Password" required>
                                    <div class="input-group-append" style="height: 38px">
                                        <span class="input-group-text" onclick="password_confirmation_show_hide();"
                                            style="border: true; background: none;">
                                            <i class="fas fa-eye" id="show_confirmation_eye"></i>
                                            <i class="fas fa-eye-slash d-none" id="hide_confirmation_eye"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        @else
                            <input required value="{{ $pembina->users->id }}" class="form-control" type="text"
                                id="id_user" name="id_user" hidden>
                            <div class="form-group">
                                <label for="nip">NIP</label>
                                <input required value="{{ $pembina->nip }}" class="form-control" type="number"
                                    id="nip" name="nip">
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama Lengkap</label>
                                <input required value="{{ $pembina->users->nama }}" class="form-control" type="text"
                                    id="nama" name="nama">
                            </div>
                            <div class="form-group">
                                <label for="nip">NIP</label>
                                <input required value="{{ $pembina->nip }}" class="form-control" type="text"
                                    id="nip" name="nip">
                            </div>
                            <div class="form-group">
                                <label for="kelas">Kelas</label>
                                <input required value="{{ $pembina->kelas }}" class="form-control" type="text"
                                    id="kelas" name="kelas">
                            </div>
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input required value="{{ $pembina->tempat_lahir }}" class="form-control" type="area"
                                    id="tempat_lahir" name="tempat_lahir">
                            </div>
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input required value="{{ $pembina->tanggal_lahir }}" class="form-control"
                                    type="date" id="tanggal_lahir" name="tanggal_lahir">
                            </div>
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-Laki"
                                        {{ $pembina->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' }}>
                                        Laki-Laki</option>
                                    <option value="Perempuan"
                                        {{ $pembina->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                            </div>
                            <div class="form-floating">
                                <label for="floatingPassword">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror" id="password"
                                        placeholder="Password" name="password" required>
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
                            <div class="form-floating">
                                <label for="password_confirmation">Ulangi Password</label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        id="password_confirmation" placeholder="Ulangi Password" required>
                                    <div class="input-group-append" style="height: 38px">
                                        <span class="input-group-text" onclick="password_confirmation_show_hide();"
                                            style="border: true; background: none;">
                                            <i class="fas fa-eye" id="show_confirmation_eye"></i>
                                            <i class="fas fa-eye-slash d-none" id="hide_confirmation_eye"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        @endif
                        <div class="form-group mt-2">
                            <button class="btn btn-primary btn-sm">Update</button>
                        </div>

                    </form>
                </div>
                <div class="card-footer"></div>
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

        function password_confirmation_show_hide() {
            var x = document.getElementById("password_confirmation");
            var show_confirmation_eye = document.getElementById("show_confirmation_eye");
            var hide_confirmation_eye = document.getElementById("hide_confirmation_eye");
            hide_confirmation_eye.classList.remove("d-none");
            if (x.type === "password") {
                x.type = "text";
                show_confirmation_eye.style.display = "none";
                hide_confirmation_eye.style.display = "block";
            } else {
                x.type = "password";
                show_confirmation_eye.style.display = "block";
                hide_confirmation_eye.style.display = "none";
            }
        }
    </script>
@endsection
