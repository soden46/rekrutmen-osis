@extends('dashboard', [
    'title' => 'Data Rekrutmen',
    'pageTitle' => 'Data Rekrutmen',
])
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="d-flex justify-content-between mb-3">
        <div>
            <form action="{{ route('siswa.rekrutmen') }}" method="GET" class="d-flex">
                <input type="text" name="cari" class="form-control" placeholder="Cari Data" value="{{ request('cari') }}">
                <button type="submit" class="btn btn-md btn-primary ml-2">Search</button>
            </form>
        </div>
        <div>
        </div>
    </div>
    <table class="table table-bordered">
        <tr class="font-12">
            <th style="width: 150px">Nama Ekskul</th>
            <th style="width: 150px">Nama Rekrutmen</th>
            <th style="width: 150px">Tanggal Dimulai</th>
            <th style="width: 150px">Tanggal Berakhir</th>
            <th style="width: 150px">Deskripsi</th>
        </tr>
        @foreach ($rekrutmen as $data)
            <tr>
                <td style="width: 150px">{{ $data->ekskul->nama_ekskul ?? '' }}</td>
                <td style="width: 150px">{{ $data->nama_rekrutmen ?? '' }}</td>
                <td style="width: 150px">{{ date('d/m/Y', strtotime($data->tanggal_dimulai ?? '')) }}</td>
                <td style="width: 150px">{{ date('d/m/Y', strtotime($data->tanggal_berakhir ?? '')) }}</td>
                <td style="width: 150px">
                    {{ Str::limit(strip_tags($data->deskripsi), 100) }}
                    <button type="button" class="btn btn-info btn-sm ml-2" data-toggle="modal"
                        data-target="#detailModal{{ $data->id_rekrutmen }}">
                        Detail
                    </button>
                </td>
            </tr>

            <!-- Modal -->
            <div class="modal fade" id="detailModal{{ $data->id_rekrutmen }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Detail Deskripsi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {!! $data->deskripsi !!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <form method="POST" action="{{ route('siswa.rekrutmen.daftar', $data->id_rekrutmen) }}">
                                @csrf
                                <button type="submit" class="btn btn-primary">Daftar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </table>
    <div class="row text-center">
        {!! $rekrutmen->links() !!}
    </div>
@endsection
