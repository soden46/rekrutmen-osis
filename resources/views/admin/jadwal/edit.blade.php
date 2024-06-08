@extends('dashboard',[
'title' => 'Edit Jadwal Tes',
'pageTitle' => 'Edit Jadwal Tes'
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
            <h5 class="card-title">Edit Jadwal Tes</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('admin.jadwal.update', $tes->id_jadwal) }}" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="form-group">
                    <label for="id_siswa">Pilih Siswa</label>
                    <select class="form-control" id="id_siswa" name="id_siswa">
                        <option value="" selected>Pilih Siswa</option>
                        @foreach($siswa as $siswas)
                        <option value="{{ $siswas->id_siswa }}" {{ $siswas->id_siswa == $tes->id_siswa ? 'selected' : '' }}>
                            {{ $siswas->id_siswa }} | {{ $siswas->users->nama ?? ''}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="nama_jadwal_tes">Nama Jadwal</label>
                    <input type="text" class="form-control" id="nama_jadwal_tes" name="nama_jadwal_tes" value="{{ $tes->nama_jadwal_tes }}">
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $tes->tanggal }}">
                </div>
                <div class="form-group">
                    <label for="jam">Jam</label>
                    <input type="time" class="form-control" id="jam" name="jam" value="{{ $tes->jam }}">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

@endsection