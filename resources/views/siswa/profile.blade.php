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
                    <form method="POST" action="{{ route('siswa.profile.update', Auth::user()->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nis">NIS</label>
                            <input required value="{{ $siswa->nis }}" class="form-control" type="text" id="nis"
                                name="nis">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input required value="{{ $siswa->users->nama }}" class="form-control" type="text"
                                id="nama" name="nama">
                        </div>
                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <input required value="{{ $siswa->kelas }}" class="form-control" type="text" id="kelas"
                                name="kelas">
                        </div>
                        <div class="form-group">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input required value="{{ $siswa->tempat_lahir }}" class="form-control" type="text"
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
                        <div class="form-group">
                            <label for="tinggi_badan">Tinggi Badan</label>
                            <input required value="{{ $siswa->tinggi_badan }}" class="form-control" type="text"
                                id="tinggi_badan" name="tinggi_badan">
                        </div>
                        <div class="form-group">
                            <label for="berat_badan">Berat Badan</label>
                            <input required value="{{ $siswa->berat_badan }}" class="form-control" type="text"
                                id="berat_badan" name="berat_badan">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-sm">Update</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
    </div>
@endsection
