@extends('dashboard', [
    'title' => 'Edit Hasil Tes',
    'pageTitle' => 'Edit Hasil Tes',
])
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('error'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Edit Hasil Tes</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.hasil.update', $hasil->id_hasil) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="id_pendaftaran">Pilih Pendaftaran</label>
                        <select class="form-control" id="id_pendaftaran" name="id_pendaftaran">
                            <option value="" selected>Pilih Pendaftaran</option>
                            @foreach ($pendaftaran as $pendaftarans)
                                <option value="{{ $pendaftarans->id_pendaftaran }}"
                                    {{ $pendaftarans->id_pendaftaran == $hasil->id_pendaftaran ? 'selected' : '' }}>
                                    {{ $pendaftarans->id_pendaftaran }} | {{ $pendaftarans->siswa->users->nama ?? '' }} |
                                    {{ $pendaftarans->tanggal ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_tes">Pilih Nama Tes</label>
                        <select class="form-control" id="nama_tes" name="nama_tes">
                            <option value="" selected>Pilih nama Tes</option>
                            <option value="tes tertulis" {{ $hasil->nama_tes == 'tes tertulis' ? 'selected' : '' }}>Tes
                                Tertulis</option>
                            <option value="tes wawancara" {{ $hasil->nama_tes == 'tes wawancara' ? 'selected' : '' }}>Tes
                                Wawancara</option>
                            <option value="tes latihan" {{ $hasil->nama_tes == 'tes latihan' ? 'selected' : '' }}>Tes
                                Latihan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="skor_final">Skor Final</label>
                        <input type="number" class="form-control" id="skor_final" name="skor_final"
                            value="{{ $hasil->skor_final }}">
                    </div>
                    <div class="form-group">
                        <label for="status">Pilih Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="" selected>Pilih Status</option>
                            <option value="Lolos" {{ $hasil->status == 'Lolos' ? 'selected' : '' }}>Lolos</option>
                            <option value="Tidak Lolos" {{ $hasil->status == 'Tidak Lolos' ? 'selected' : '' }}>Tidak Lolos
                            </option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
