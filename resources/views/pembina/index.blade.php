@extends('dashboard', [
    'title' => 'Dashboard',
    'pageTitle' => 'Dashboard',
])
@section('content')
    <div class="row">
        @if (session()->has('loginSuccess'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('loginSuccess') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <style>
            .mainMenu:hover {
                background-color: gainsboro;
            }
        </style>
        <div class="col-md-3 mb-4">
            <div class="card d-inline-flex mainMenu"
                style="width: 100%; padding: 12px; border-left: 5px solid indigo; margin-bottom: 20px;">
                <a href="{{ route('pembina.rekrutmen') }}" style="text-decoration: none; color: black;">
                    <div class="d-flex">
                        <div style="width: 100%;">
                            <h6 style="color: indigo;">Jumlah Rekrutmen</h6>
                            <h4>{{ $jumlahRekrutmen }}</h4>
                        </div>
                        <div style="width: auto;">
                            <h1><span style="color: black; vertical-align: middle;" class="bi bi-people"></span></h1>
                        </div>
                    </div>
                    <div class="card-footer border bg-transparent" style="width: 100%;">View Details</div>
                </a>
            </div>
        </div>
        @foreach ($jumlahPendaftar as $namaEkskul => $jumlah)
            <div class="col-md-3 mb-4">
                <div class="card d-inline-flex mainMenu"
                    style="width: 100%; padding: 12px; border-left: 5px solid #1746a2; margin-bottom: 20px;">
                    <a href="{{ route('pembina.pendaftaran') }}" style="text-decoration: none; color: black;">
                        <div class="d-flex">
                            <div style="width: 100%;">
                                <h6 style="color: #1746a2;">Jumlah Pendaftar {{ ucfirst($namaEkskul) }}</h6>
                                <h4>{{ $jumlah }}</h4>
                            </div>
                            <div style="width: auto;">
                                <h1><span style="color: black; vertical-align: middle;"
                                        class="bi bi-file-earmark-text"></span></h1>
                            </div>
                        </div>
                        <div class="card-footer border bg-transparent" style="width: 100%;">View Details</div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@stop
