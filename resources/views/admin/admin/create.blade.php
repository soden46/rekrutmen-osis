@extends('dashboard',[
'title' => 'Tambah Admin',
'pageTitle' => 'Tambah Admin'
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
            <h5 class="card-title">Tambah Admin</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('admin.admin.save') }}" enctype="multipart/form-data">
                @csrf
                @method("POST")
                <div class="form-group">
                    <label for="id_user">Pilih Pengguna</label>
                    <select class="form-control" id="id_user" name="id_user">
                        <option value="" selected>Pilih Pengguna</option>
                        @foreach($user as $admin)
                        <option value="{{ $admin->id }}">{{ $admin->id }} | {{ $admin->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="nip">NIP</label>
                    <input type="text" class="form-control" id="nip" name="nip">
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

                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </form>
        </div>
    </div>
</div>

@endsection