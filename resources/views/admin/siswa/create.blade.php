@extends('dashboard', [
    'title' => 'Tambah Siswa',
    'pageTitle' => 'Tambah Siswa',
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
                <h5 class="card-title">Tambah Siswa</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.siswa.save') }}" enctype="multipart/form-data">
                    @csrf

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
                    <div class="form-floating">
                        <label for="floatingInput">Username</label>
                        <input type="text" name="username" class="form-control @error('username')is-invalid @enderror"
                            id="floatingInput" placeholder="Username" required value="{{ old('username') }}">
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <label for="floatingInput">Email</label>
                        <input type="email" name="email" class="form-control @error('email')is-invalid @enderror"
                            id="floatingInput" placeholder="akun@gmail.com" required value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <label for="floatingPassword">Password</label>
                        <input type="password" name="password" class="form-control @error('password')is-invalid @enderror"
                            id="floatingPassword" placeholder="Password" required>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
