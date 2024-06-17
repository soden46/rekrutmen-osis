@extends('dashboard', [
    'title' => 'Edit Pendaftaran',
    'pageTitle' => 'Edit Pendaftaran',
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
                <h5 class="card-title">Edit Pendaftaran</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('siswa.pendaftaran.update', $pendaftaran->id_pendaftaran) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="id_siswa">Pilih Siswa</label>
                        <select class="form-control" id="id_siswa" name="id_siswa">
                            <option value="" selected>Pilih Siswa</option>
                            @foreach ($siswa as $siswas)
                                <option value="{{ $siswas->id_siswa }}"
                                    {{ $siswas->id_siswa == $pendaftaran->id_siswa ? 'selected' : '' }}>
                                    {{ $siswas->id_siswa }} | {{ $siswas->users->nama ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_rekrutmen">Pilih Rekrutmen</label>
                        <select class="form-control" id="id_rekrutmen" name="id_rekrutmen">
                            <option value="" selected>Pilih Rekrutmen</option>
                            @foreach ($rekrutmen as $rekrutmen)
                                <option value="{{ $rekrutmen->id_rekrutmen }}"
                                    {{ $rekrutmen->id_rekrutmen == $pendaftaran->id_rekrutmen ? 'selected' : '' }}>
                                    {{ $rekrutmen->id_rekrutmen }} | {{ $rekrutmen->nama_lowongan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                            value="{{ $pendaftaran->tanggal }}">
                    </div>
                    <div class="form-group">
                        <label for="status">Pilih Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="" selected>Pilih Status</option>
                            <option value="Diterima" {{ $pendaftaran->status == 'Diterima' ? 'selected' : '' }}> Diterima
                            </option>
                            <option value="Ditolak" {{ $pendaftaran->status == 'Ditolak' ? 'selected' : '' }}> Ditolak
                            </option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
