@extends('dashboard', [
    'title' => 'Dashboard iswa',
    'pageTitle' => 'Dashboard iswa',
])
@section('content')
    <div class="row">
        <div class="card text-white bg-info col-sm-4">
            <div class="card-body">
                <h5 class="card-title">Jumlah Rekrutmen Dibuka</h5>
                <h2 class="card-text">
                    <i class="fa fa-clipboard-list"> {{ $rekrutmen }}</i>
                </h2><br>
                <a href="{{ route('siswa.rekrutmen') }}" class="btn btn-primary">Lihat Selengkapnya</a>
            </div>
        </div>
        <div class="card text-white bg-warning col-sm-4">
            <div class="card-body">
                <h5 class="card-title">Isi Biodata</h5>
                <p class="card-text">
                    Isi biodata anda dengan cara mengeklik menu biodata sebelum mengajukan pendaftaran melaluli halaman
                    pendaftaran
                <p>
            </div>
        </div>
        <div class="card text-white bg-info col-sm-4">
            <div class="card-body">
                <h5 class="card-title">Cara Mengajukan Pendaftaran</h5>
                <p class="card-text">
                    1. Klik menu rekrutmen untuk melihat rekrutmen yang dibuka<br>
                    2. Klik Lihat rekrutmen Pada tombol list rekrutmen<br>
                    3. Klik menu rekrutmen
                    3. Klik tombol ajukan pendaftaran
                    5. Isi data yang diperlukan
                    6. Klik tombol daftar
                </p>
            </div>
        </div>
    </div>
@endsection
