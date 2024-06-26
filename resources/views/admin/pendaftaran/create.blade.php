@extends('dashboard',[
'title' => 'Tambah Pendaftaran',
'pageTitle' => 'Tambah Pendaftaran'
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
            <h5 class="card-title">Tambah Pendaftaran</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('admin.pendaftaran.save') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="id_siswa">Pilih Siswa</label>
                    <select class="form-control" id="id_siswa" name="id_siswa">
                        <option value="" selected>Pilih Siswa</option>
                        @foreach($siswa as $siswas)
                        <option value="{{ $siswas->id_siswa }}">{{ $siswas->id_siswa }} | {{ $siswas->users->nama ?? ''}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_rekrutmen">Pilih Rekrutmen</label>
                    <select class="form-control" id="id_rekrutmen" name="id_rekrutmen">
                        <option value="" selected>Pilih Rekrutmen</option>
                        @foreach($rekrutmen as $rekrutmen)
                        <option value="{{ $rekrutmen->id_rekrutmen }}">{{ $rekrutmen->id_rekrutmen }} | {{ $rekrutmen->nama_lowongan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal">
                </div>
                <div class="form-group">
                    <label for="status">Pilih Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="" selected>Pilih Ekskul</option>
                        <option value="Diterima"> Diterima</option>
                        <option value="Ditolak"> Ditolak</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

@endsection