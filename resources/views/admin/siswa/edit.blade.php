@extends('dashboard',[
'title' => 'Edit Siswa',
'pageTitle' => 'Edit Siswa'
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
            <h5 class="card-title">Edit Siswa</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('admin.siswa.update',$siswa->id_siswa) }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="id_user">Nama Siswa</label>
                    <input type="text" class="form-control" id="id_user" name="id_user" value="{{$siswa->users->nama}}" readonly>
                </div>
                <div class="form-group">
                    <label for="nis">NIS</label>
                    <input type="text" class="form-control" id="nis" name="nis" value="{{$siswa->nis}}">
                </div>
                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <input type="text" class="form-control" id="kelas" name="kelas" value="{{$siswa->kelas}}">
                </div>
                <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{$siswa->tempat_lahir}}">
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{$siswa->tanggal_lahir}}">
                </div>
                <div class="form-group">
                    <label for="jenis_kelamin">Pilih Jenis Kelamin</label>
                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                        <option value="Laki-Laki" {{ $siswa->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                        <option value="Perempuan" {{ $siswa->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat">{{ $siswa->alamat }}</textarea>
                </div>
                <div class="form-group">
                    <label for="tinggi_badan">Tinggi Badan</label>
                    <input type="number" class="form-control" id="tinggi_badan" name="tinggi_badan" value="{{$siswa->tinggi_badan}}">
                </div>
                <div class="form-group">
                    <label for="berat_badan">Berat Badan</label>
                    <input type="number" class="form-control" id="berat_badan" name="berat_badan" value="{{$siswa->berat_badan}}">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

@endsection