@extends('dashboard',[
'title' => 'Data Hasil Akhir',
'pageTitle' => 'Data Hasil Akhir'
])
@section('content')

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif
<div class="d-flex justify-content-between mb-3">
    <div>
        <form action="{{ route('admin.hasil') }}" method="GET" class="d-flex">
            <input type="text" name="cari" class="form-control" placeholder="Cari Data" value="{{ request('cari') }}">
            <button type="submit" class="btn btn-md btn-primary ml-2">Search</button>
        </form>
    </div>
    <div>
        <a class="btn btn-md btn-success mr-2" href="{{ route('admin.hasil.create') }}"><i class="fa fa-plus"></i> Tambah Data</a>
        <a class="btn btn-md btn-success" href="{{ route('admin.hasil.cetak') }}" target="_blank"><i class="fa fa-print"></i> Cetak PDF</a>
    </div>
</div>
<table class="table table-bordered">
    <tr class="font-12">
        <th style="width: 150px">Id hasil</th>
        <th style="width: 150px">Nama Siswa</th>
        <th style="width: 150px">Nama Tes</th>
        <th style="width: 150px">Skor Final</th>
        <th style="width: 150px">Status</th>
        <th style="width: 100px">Aksi</th>
    </tr>
    @foreach ($hasil as $data)
    <tr>
        <td style="width: 150px">{{ $data->id_hasil }}</td>
        <td style="width: 150px">{{ $data->pendaftaran->siswa->users->nama ?? ''}}</td>
        <td style="width: 150px">{{$data->nama_tes}}</td>
        <td style="width: 150px">{{$data->skor_final}}</td>
        <td style="width: 150px">{{$data->status}}</td>
        <td>
            <div class="btn-group" style="width:135px">
                <form action="{{ route('admin.hasil.destroy',$data->id_hasil) }}" method="Post">
                    <a class="btn btn-primary" href="{{ route('admin.hasil.edit',$data->id_hasil) }}">Edit</a>
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
    {!! $hasil->links() !!}
</div>

@endsection