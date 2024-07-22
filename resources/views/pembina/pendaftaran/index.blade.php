@extends('dashboard', [
    'title' => 'Data Pendaftaran',
    'pageTitle' => 'Data Pendaftaran',
])
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="d-flex justify-content-between mb-3">
        <div>
            <form action="{{ route('pembina.pendaftaran') }}" method="GET" class="d-flex">
                <input type="text" name="cari" class="form-control" placeholder="Cari Data" value="{{ request('cari') }}">
                <button type="submit" class="btn btn-md btn-primary ml-2">Search</button>
            </form>
        </div>
        <div>
            {{-- <a class="btn btn-md btn-success mr-2" href="{{ route('pembina.pendaftaran.create') }}"><i
                    class="fa fa-plus"></i> Tambah Data</a> --}}
            <a class="btn btn-md btn-success" href="{{ route('pembina.pendaftaran.cetak') }}" target="_blank"><i
                    class="fa fa-print"></i> Cetak PDF</a>
        </div>
    </div>
    <table class="table table-bordered">
        <tr class="font-12">
            <th style="width: 150px">Id Pendaftaran</th>
            <th style="width: 150px">Nama Siswa</th>
            <th style="width: 150px">Nama Rekrutmen</th>
            <th style="width: 150px">Tanggal</th>
            @if (
                $pendaftaran->isNotEmpty() &&
                    ($pendaftaran->first()->rekrutmen->ekskul->nama_ekskul === 'osis' ||
                        $pendaftaran->first()->rekrutmen->ekskul->nama_ekskul === 'Osis'))
                <th style="width: 150px">Nilai Tertulis</th>
                <th style="width: 150px">Nilai Wawancara</th>
            @endif
            @if (
                $pendaftaran->isNotEmpty() &&
                    ($pendaftaran->first()->rekrutmen->ekskul->nama_ekskul === 'tonti' ||
                        $pendaftaran->first()->rekrutmen->ekskul->nama_ekskul === 'Tonti'))
                <th style="width: 150px">Nilai Seleksi Latihan Tonti</th>
            @endif
            @if (
                $pendaftaran->isNotEmpty() &&
                    ($pendaftaran->first()->rekrutmen->ekskul->nama_ekskul === 'osis' ||
                        $pendaftaran->first()->rekrutmen->ekskul->nama_ekskul === 'Osis'))
                <th style="width: 150px">Nilai Rata Rata</th>
            @endif
            <th style="width: 150px">Kartu pelajar</th>
            <th style="width: 150px">Surat Izin</th>
            <th style="width: 150px">Foto</th>
            <th style="width: 150px">Status</th>
            <th style="width: 100px">Aksi</th>
        </tr>
        @foreach ($pendaftaran as $data)
            <tr>
                <td style="width: 150px">{{ $data->id_pendaftaran ?? '' }}</td>
                <td style="width: 150px">{{ $data->siswa->users->nama ?? '' }}</td>
                <td style="width: 150px">{{ $data->rekrutmen->nama_rekrutmen ?? '' }}</td>
                <td style="width: 150px">{{ $data->tanggal ?? '' }}</td>
                @if ($data->rekrutmen->ekskul->nama_ekskul === 'osis' || $data->rekrutmen->ekskul->nama_ekskul === 'Osis')
                    <td style="width: 150px">{{ $data->nilai_tertulis ?? '' }}</td>
                    <td style="width: 150px">{{ $data->nilai_wawancara ?? '' }}</td>
                @endif
                @if ($data->rekrutmen->ekskul->nama_ekskul === 'tonti' || $data->rekrutmen->ekskul->nama_ekskul === 'Tonti')
                    <td style="width: 150px">{{ $data->nilai_seleksi_latihan_tonti ?? '' }}</td>
                @endif
                @if ($data->rekrutmen->ekskul->nama_ekskul === 'osis' || $data->rekrutmen->ekskul->nama_ekskul === 'Osis')
                    <td style="width: 150px">{{ $data->rata_rata ?? '' }}</td>
                @endif
                <td style="width: 150px">
                    @php
                        $kartuPelajar = $data->dokumen->where('type', 'kartu_pelajar')->first();
                    @endphp
                    @if ($kartuPelajar)
                        <img src="{{ asset('dokumen_pendaftaran/' . $kartuPelajar->path) }}" alt="Kartu Pelajar"
                            style="max-width: 100px; max-height: 100px;">
                    @else
                        Tidak ada data
                    @endif
                </td>
                <td style="width: 150px">
                    @php
                        $suratIzin = $data->dokumen->where('type', 'suart_izin')->first();
                    @endphp
                    @if ($suratIzin)
                        <img src="{{ asset('dokumen_pendaftaran/' . $suratIzin->path) }}" alt="Surat Izin"
                            style="max-width: 100px; max-height: 100px;">
                    @else
                        Tidak ada data
                    @endif
                </td>
                <td style="width: 150px">
                    @php
                        $passFoto = $data->dokumen->where('type', 'pass_foto')->first();
                    @endphp
                    @if ($passFoto)
                        <img src="{{ asset('dokumen_pendaftaran/' . $passFoto->path) }}" alt="Pass Foto"
                            style="max-width: 100px; max-height: 100px;">
                    @else
                        Tidak ada data
                    @endif
                </td>
                <td style="width: 150px">{{ $data->status ?? '' }}</td>
                <td>
                    <div class="btn-group" style="width:135px">
                        <form action="{{ route('pembina.pendaftaran.destroy', $data->id_pendaftaran) }}" method="Post">
                            <a class="btn btn-primary"
                                href="{{ route('pembina.pendaftaran.edit', $data->id_pendaftaran) }}">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="row text-center">
        {!! $pendaftaran->links() !!}
    </div>
@endsection
