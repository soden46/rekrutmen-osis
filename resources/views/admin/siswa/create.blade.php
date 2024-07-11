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

                    <div class="form-group">
                        <label for="nis">NIS</label>
                        <input class="form-control" type="number" id="nis" name="nis">
                    </div>

                    <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <input class="form-control" type="text" id="kelas" name="kelas">
                    </div>
                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input class="form-control" type="area" id="tempat_lahir" name="tempat_lahir">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input class="form-control" type="date" id="tanggal_lahir" name="tanggal_lahir">
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                            <option value="" selected>Pilih Jenis Kelamin</option>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tinggi_badan">Tinggi Badan</label>
                        <input class="form-control" type="number" id="tinggi_badan" name="tinggi_badan">
                    </div>
                    <div class="form-group">
                        <label for="berat_badan">Berat Badan</label>
                        <input class="form-control" type="number" id="berat_badan" name="berat_badan">
                    </div>

                    <div class="form-floating">
                        <label for="floatingPassword">Password</label>
                        <input type="password" name="password" class="form-control @error('password')is-invalid @enderror"
                            id="floatingPassword" placeholder="Password" required>
                        <input type="checkbox" id="showPassword" onclick="togglePasswordVisibility()"> Show Password
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
@endsection

@section('scripts')
    <script>
        function togglePasswordVisibility() {
            var passwordField = document.getElementById("floatingPassword");
            var showPasswordCheckbox = document.getElementById("showPassword");
            if (
