@extends('dashboard',[
'title' => 'Data Rekrutmen',
'pageTitle' => 'Data Rekrutmen'
])
@section('content')

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif
<div class="d-flex justify-content-between mb-3">
    <div>
        <form action="{{ route('admin.rekrutmen') }}" method="GET" class="d-flex">
            <input type="text" name="cari" class="form-control" placeholder="Cari Data" value="{{ request('cari') }}">
            <button type="submit" class="btn btn-md btn-primary ml-2">Search</button>
        </form>
    </div>
    <div>
        <a class="btn btn-md btn-success mr-2" href="{{ route('admin.rekrutmen.create') }}"><i class="fa fa-plus"></i> Tambah Data</a>
        <a class="btn btn-md btn-success" href="{{ route('admin.rekrutmen.cetak') }}" target="_blank"><i class="fa fa-print"></i> Cetak PDF</a>
    </div>
</div>
<table class="table table-bordered">
    <tr class="font-12">
        <th style="width: 150px">Nama Ekskul</th>
        <th style="width: 150px">Nama Lowongan</th>
        <th style="width: 150px">Tanggal Dimulai</th>
        <th style="width: 150px">Tanggal Berakhir</th>
        <th style="width: 150px">Deskripsi</th>
        <th style="width: 100px">Aksi</th>
    </tr>
    @foreach ($rekrutmen as $data)
    <tr>
        <td style="width: 150px">{{ $data->ekskul->nama_ekskul ?? ''}}</td>
        <td style="width: 150px">{{ $data->nama_lowongan ?? ''}}</td>
        <td style="width: 150px">{{ date('d/m/Y', strtotime($data->tanggal_dimulai ?? ''))}}</td>
        <td style="width: 150px">{{ date('d/m/Y', strtotime($data->tanggal_berakhir ?? ''))}}</td>
        <td style="width: 150px">
            {{ Str::limit(strip_tags($data->deskripsi), 100) }}
            <button type="button" class="btn btn-info btn-sm ml-2" data-toggle="modal" data-target="#detailModal{{ $data->id }}">
                Detail
            </button>
        </td>
        <td>
            <div class="btn-group" style="width:135px">
                <form action="{{ route('admin.rekrutmen.destroy', $data->id_rekrutmen) }}" method="Post">
                    <a class="btn btn-primary" href="{{ route('admin.rekrutmen.edit', $data->id_rekrutmen) }}">Edit</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </td>
    </tr>

    <!-- Modal -->
    <div class="modal fade" id="detailModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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