@extends('dashboard',[
'title' => 'Tambah Pembina',
'pageTitle' => 'Tambah Pembina'
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
                    <label for="id_user">Jadikan Pembina</label>
                    <select class="form-control" id="id_user" name="id_user">
                        <option value="" selected>Jadikan Pembina</option>
                        @foreach($user as $pemb)
                        <option value="{{ $pemb->id }}">{{ $pemb->id }} | {{ $pemb->nama }}</option>
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
            </form>
        </div>
    </div>
</div>

@endsection