@extends('dashboard',[
'title' => 'Edit Admin',
'pageTitle' => 'Edit Admin'
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
            <h5 class="card-title">Edit Admin</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('admin.admin.update',$admin->id_admin) }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="id_user">Nama Admin</label>
                    <input type="text" class="form-control" id="id_user" name="id_user" value="{{$admin->users->nama}}" readonly>
                </div>
                <div class="form-group">
                    <label for="nip">NIP</label>
                    <input type="text" class="form-control" id="nip" name="nip" value="{{$admin->nip}}">
                </div>
                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <input type="text" class="form-control" id="kelas" name="kelas" value="{{$admin->kelas}}">
                </div>
                <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{$admin->tempat_lahir}}">
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{$admin->tanggal_lahir}}">
                </div>
                <div class="form-group">
                    <label for="jenis_kelamin">Pilih Jenis Kelamin</label>
                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                        <option value="Laki-Laki" {{ $admin->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                        <option value="Perempuan" {{ $admin->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat">{{ $admin->alamat }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </form>
        </div>
    </div>
</div>

@endsection