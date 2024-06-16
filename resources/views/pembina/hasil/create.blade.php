@extends('dashboard',[
'title' => 'Tambah Hasil Tes',
'pageTitle' => 'Tambah Hasil Tes'
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
            <h5 class="card-title">Tambah Hasil Tes</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('pembina.hasil.save') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="id_pendaftaran">Pilih Pendaftaran</label>
                    <select class="form-control" id="id_pendaftaran" name="id_pendaftaran">
                        <option value="" selected>Pilih Pendaftaran</option>
                        @foreach($pendaftaran as $pendaftaran)
                        <option value="{{ $pendaftaran->id_pendaftaran }}">{{ $pendaftaran->id_pendaftaran }} | {{ $pendaftaran->siswa->users->nama ?? ''}} | {{ $pendaftaran->tanggal ?? ''}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="nama_tes">Pilih Nama Tes</label>
                    <select class="form-control" id="nama_tes" name="nama_tes">
                        <option value="" selected>Pilih nama Tes</option>
                        <option value="tes tertulis">Tes Tertulis</option>
                        <option value="tes wawancara"> Tes Wawancara</option>
                        <option value="tes latihan"> Tes Latihan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="skor_final">Skor Final</label>
                    <input type="number" class="form-control" id="skor_final" name="skor_final">
                </div>
                <div class="form-group">
                    <label for="status">Pilih Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="" selected>Pilih Status</option>
                        <option value="Lolos">Lolos</option>
                        <option value="Tidak Lolos"> Tidak Lolos</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

@endsection