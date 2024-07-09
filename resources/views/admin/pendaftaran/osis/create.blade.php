@extends('dashboard', [
    'title' => 'Tambah Pendaftaran',
    'pageTitle' => 'Tambah Pendaftaran',
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
                <h5 class="card-title">Tambah Pendaftaran Osis</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.pendaftaran.osis.save') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="id_siswa">Pilih Siswa</label>
                        <select class="form-control" id="id_siswa" name="id_siswa">
                            <option value="" selected>Pilih Siswa</option>
                            @foreach ($siswa as $siswas)
                                <option value="{{ $siswas->id_siswa }}">{{ $siswas->id_siswa }} |
                                    {{ $siswas->users->nama ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_rekrutmen">Pilih Rekrutmen</label>
                        <select class="form-control" id="id_rekrutmen" name="id_rekrutmen">
                            <option value="" selected>Pilih Rekrutmen</option>
                            @foreach ($rekrutmen as $rekrutmen)
                                <option value="{{ $rekrutmen->id_rekrutmen }}">{{ $rekrutmen->id_rekrutmen }} |
                                    {{ $rekrutmen->nama_rekrutmen }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal">
                    </div>
                    <div class="form-group">
                        <label for="nilai_tertulis">Nilai Tertulis</label>
                        <input type="number" class="form-control" id="nilai_tertulis" name="nilai_tertulis">
                    </div>
                    <div class="form-group">
                        <label for="nilai_wawancara">Nilai Wawancara</label>
                        <input type="number" class="form-control" id="nilai_wawancara" name="nilai_wawancara">
                    </div>
                    <div class="form-group">
                        <label for="rata_rata">Rata Rata</label>
                        <input type="text" class="form-control" id="rata_rata" name="rata_rata" readonly>
                    </div>
                    <div class="form-group">
                        <label for="status">Pilih Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="" selected>Pilih Ekskul</option>
                            <option value="Lolos"> Lolos</option>
                            <option value="Tidak Lolos"> Tidak Lolos</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
