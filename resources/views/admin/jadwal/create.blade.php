@extends('dashboard', [
    'title' => 'Tambah Jadwal Tes',
    'pageTitle' => 'Tambah Jadwal Tes',
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
                <h5 class="card-title">Tambah Jadwal Tes</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.jadwal.save') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="id_rekrutmen">Pilih Rekrutmen</label>
                        <select class="form-control" id="id_rekrutmen" name="id_rekrutmen">
                            <option value="" selected>Pilih Rekrutmen</option>
                            @foreach ($rekrutmen as $rekrutmens)
                                <option value="{{ $rekrutmens->id_rekrutmen }}">{{ $rekrutmens->id_rekrutmen }} |
                                    {{ $rekrutmens->nama_lowongan ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_jadwal_tes">Nama Jadwal</label>
                        <input type="text" class="form-control" id="nama_jadwal_tes" name="nama_jadwal_tes">
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal">
                    </div>
                    <div class="form-group">
                        <label for="jam">Jam</label>
                        <input type="time" class="form-control" id="jam" name="jam">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
