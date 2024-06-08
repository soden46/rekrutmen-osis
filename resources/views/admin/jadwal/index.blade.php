@extends('dashboard',[
'title' => 'Data Jadwal Tes',
'pageTitle' => 'Data Jadwal Tes'
])
@section('content')

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif
<div class="d-flex justify-content-between mb-3">
    <div>
        <form action="{{ route('admin.jadwal') }}" method="GET" class="d-flex">
            <input type="text" name="cari" class="form-control" placeholder="Cari Data" value="{{ request('cari') }}">
            <button type="submit" class="btn btn-md btn-primary ml-2">Search</button>
        </form>
    </div>
    <div>
        <a class="btn btn-md btn-success mr-2" href="{{ route('admin.jadwal.create') }}"><i class="fa fa-plus"></i> Tambah Data</a>
        <a class="btn btn-md btn-success" href="{{ route('admin.jadwal.cetak') }}" target="_blank"><i class="fa fa-print"></i> Cetak PDF</a>
    </div>
</div>
<table class="table table-bordered">
    <tr class="font-12">
        <th style="width: 150px">Id jadwal</th>
        <th style="width: 150px">Nama Siswa</th>
        <th style="width: 150px">Nama Jadwal Tes</th>
        <th style="width: 150px">Tanggal</th>
        <th style="width: 150px">Jam</th>
        <th style="width: 100px">Aksi</th>
    </tr>
    @foreach ($tes as $data)
    <tr>
        <td style="width: 150px">{{ $data->id_jadwal }}</td>
        <td style="width: 150px">{{ $data->siswa->users->nama ?? ''}}</td>
        <td style="width: 150px">{{$data->nama_jadwal_tes}}</td>
        <td style="width: 150px">{{$data->tanggal}}</td>
        <td style="width: 150px">{{$data->jam}}</td>
        <td>
            <div class="btn-group" style="width:135px">
                <form action="{{ route('admin.jadwal.destroy',$data->id_jadwal) }}" method="Post">
                    <a class="btn btn-primary" href="{{ route('admin.jadwal.edit',$data->id_jadwal) }}">Edit</a>
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
    {!! $tes->links() !!}
</div>

@endsection