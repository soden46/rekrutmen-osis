@extends('dashboard', [
    'title' => 'Edit Pendaftaran',
    'pageTitle' => 'Edit Pendaftaran',
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
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title">Edit Pendaftaran Osis</h5>
                <div class="dokumen d-flex flex-column">
                    @if (isset($dokumen['kartu_pelajar']) && $dokumen['kartu_pelajar']->isNotEmpty())
                        <a href="{{ asset($dokumen['kartu_pelajar']->first()->path) }}" target="_blank">Lihat Kartu
                            Pelajar</a>
                    @endif

                    @if (isset($dokumen['surat_izin']) && $dokumen['surat_izin']->isNotEmpty())
                        <a href="{{ asset($dokumen['surat_izin']->first()->path) }}" target="_blank">Lihat Surat Izin</a>
                    @endif

                    @if (isset($dokumen['pas_foto']) && $dokumen['pas_foto']->isNotEmpty())
                        <a href="{{ asset($dokumen['pas_foto']->first()->path) }}" target="_blank">Lihat Pas Foto</a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.pendaftaran.osis.update', $pendaftaran->id_pendaftaran) }}"
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
                        <label for="nilai_tertulis">Nilai Tertulis</label>
                        <input type="number" class="form-control" id="nilai_tertulis" name="nilai_tertulis"
                            value="{{ $pendaftaran->nilai_tertulis }}">
                    </div>
                    <div class="form-group">
                        <label for="nilai_wawancara">Nilai Wawancara</label>
                        <input type="number" class="form-control" id="nilai_wawancara" name="nilai_wawancara"
                            value="{{ $pendaftaran->nilai_wawancara }}">
                    </div>
                    <div class="form-group">
                        <label for="rata_rata">Rata Rata</label>
                        <input type="text" class="form-control" id="rata_rata" name="rata_rata"
                            value="{{ ($pendaftaran->nilai_tertulis + $pendaftaran->nilai_wawancara) / 2 }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="status">Pilih Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="" selected>Pilih Status</option>
                            <option value="Lolos" {{ $pendaftaran->status == 'Lolos' ? 'selected' : '' }}> Lolos
                            </option>
                            <option value="Tidak Lolos" {{ $pendaftaran->status == 'Tidak Lolos' ? 'selected' : '' }}>
                                Tidak Lolos
                            </option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nilaiTertulisInput = document.getElementById('nilai_tertulis');
            const nilaiWawancaraInput = document.getElementById('nilai_wawancara');
            const rataRataInput = document.getElementById('rata_rata');

            function calculateRataRata() {
                const nilaiTertulis = parseFloat(nilaiTertulisInput.value) || 0;
                const nilaiWawancara = parseFloat(nilaiWawancaraInput.value) || 0;
                const rataRata = (nilaiTertulis + nilaiWawancara) / 2;
                rataRataInput.value = rataRata.toFixed(2);
            }

            nilaiTertulisInput.addEventListener('input', calculateRataRata);
            nilaiWawancaraInput.addEventListener('input', calculateRataRata);
        });
    </script>
@endsection
