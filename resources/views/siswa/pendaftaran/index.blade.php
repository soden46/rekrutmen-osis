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
            <form action="{{ route('siswa.pendaftaran') }}" method="GET" class="d-flex">
                <input type="text" name="cari" class="form-control" placeholder="Cari Data" value="{{ request('cari') }}">
                <button type="submit" class="btn btn-md btn-primary ml-2">Search</button>
            </form>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr class="font-12">
                <th style="width: 150px">Id Pendaftaran</th>
                <th style="width: 150px">Nama Siswa</th>
                <th style="width: 150px">Nama Rekrutmen</th>
                <th style="width: 150px">Tanggal</th>
                <th style="width: 150px">Ekskul</th>
                <th style="width: 150px">Status</th>

                <th style="width: 150px">Nilai Tertulis</th>
                <th style="width: 150px">Nilai Wawancara</th>
                <th style="width: 150px">Nilai Rata Rata</th>

                <th style="width: 150px">Nilai Seleksi Latihan Tonti</th>
                <th style="width: 150px">Kartu pelajar</th>
                <th style="width: 150px">Surat Izin</th>
                <th style="width: 150px">Foto</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($pendaftaran as $data)
                <tr>
                    <td style="width: 150px">{{ $data->id_pendaftaran ?? '' }}</td>
                    <td style="width: 150px">{{ $data->siswa->users->nama ?? '' }}</td>
                    <td style="width: 150px">{{ $data->rekrutmen->nama_rekrutmen ?? '' }}</td>
                    <td style="width: 150px">{{ $data->tanggal ?? '' }}</td>
                    <td style="width: 150px">{{ $data->rekrutmen->ekskul->nama_ekskul ?? '' }}</td>
                    <td style="width: 150px">{{ $data->status ?? '' }}</td>
                    <td style="width: 150px">{{ $data->nilai_tertulis ?? '' }}</td>
                    <td style="width: 150px">{{ $data->nilai_wawancara ?? '' }}</td>
                    <td style="width: 150px">{{ $data->rata_rata ?? '' }}</td>
                    <td style="width: 150px">{{ $data->nilai_seleksi_latihan_tonti ?? '' }}</td>
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
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row text-center">
        {!! $pendaftaran->links() !!}
    </div>
@endsection
