@extends('dashboard',[
'title' => 'Data Ekstrakulikuler',
'pageTitle' => 'Data Ekstrakulikuler'
])
@section('content')

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif
<div class="d-flex justify-content-between mb-3">
    <div>
        <form action="{{ route('admin.ekskul') }}" method="GET" class="d-flex">
            <input type="text" name="cari" class="form-control" placeholder="Cari Data" value="{{ request('cari') }}">
            <button type="submit" class="btn btn-md btn-primary ml-2">Search</button>
        </form>
    </div>
    <div>
        <a class="btn btn-md btn-success mr-2" href="{{ route('admin.ekskul.create') }}"><i class="fa fa-plus"></i> Tambah Data</a>
        <a class="btn btn-md btn-success" href="{{ route('admin.ekskul.cetak') }}" target="_blank"><i class="fa fa-print"></i> Cetak PDF</a>
    </div>
</div>
<table class="table table-bordered">
    <tr class="font-12">
        <th style="width: 150px">Nama Ekskul</th>
        <th style="width: 150px">Nama Pembina</th>
        <th style="width: 150px">Jumlah Anggota</th>
        <th style="width: 100px">Aksi</th>
    </tr>
    @foreach ($ekskul as $ekstra)
    <tr>
        <td style="width: 150px">{{ $ekstra->nama_ekskul }}</td>
        <td style="width: 150px">{{ $ekstra->pembina->nama ?? ''}}</td>
        <td style="width: 150px">{{$ekstra->jml_anggota}}</td>
        <td>
            <div class="btn-group" style="width:135px">
                <form action="{{ route('admin.ekskul.destroy',$ekstra->id_ekskul) }}" method="Post">
                    <a class="btn btn-primary" href="{{ route('admin.ekskul.edit',$ekstra->id_ekskul) }}">Edit</a>
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
    {!! $ekskul->links() !!}
</div>

@endsection