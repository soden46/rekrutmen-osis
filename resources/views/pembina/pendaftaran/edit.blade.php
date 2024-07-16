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
                <form method="post" action="{{ route('pembina.pendaftaran.update', $pendaftaran->id_pendaftaran) }}"
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
                                    data-nama-ekskul="{{ $rekrutmen->ekskul->nama_ekskul }}"
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
                    @if ($pendaftarn->rekrutmen->ekskul->nama_ekskul === 'osis' || $pendaftarn->rekrutmen->ekskul->nama_ekskul === 'Osis')
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
                    @endif
                    <div class="form-group" id="nilai_seleksi_latihan_tonti_group">
                        <label for="nilai_seleksi_latihan_tonti">Nilai Seleksi Latihan</label>
                        <input type="number" class="form-control" id="nilai_seleksi_latihan_tonti"
                            name="nilai_seleksi_latihan_tonti" value="{{ $pendaftaran->nilai_seleksi_latihan_tonti }}">
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
        function toggleNilaiSeleksiLatihanTonti() {
            const rekrutmenSelect = document.getElementById('id_rekrutmen');
            const nilaiSeleksiLatihanTontiGroup = document.getElementById('nilai_seleksi_latihan_tonti_group');
            const selectedOption = rekrutmenSelect.options[rekrutmenSelect.selectedIndex];
            const namaEkskul = selectedOption.getAttribute('data-nama-ekskul').toLowerCase();
            if (namaEkskul.includes('tonti')) {
                nilaiSeleksiLatihanTontiGroup.style.display = 'block';
            } else {
                nilaiSeleksiLatihanTontiGroup.style.display = 'none';
            }
        }

        document.getElementById('id_rekrutmen').addEventListener('change', toggleNilaiSeleksiLatihanTonti);

        // Inisialisasi pada saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            toggleNilaiSeleksiLatihanTonti();
        });
    </script>
@endsection
