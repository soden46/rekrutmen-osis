@extends('dashboard',[
'title' => 'Data Siswa',
'pageTitle' => 'Data Siswa'
])
@section('content')

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif
<div class="d-flex justify-content-between mb-3">
    <div>
        <form action="{{ route('admin.siswa') }}" method="GET" class="d-flex">
            <input type="text" name="cari" class="form-control" placeholder="Cari Data" value="{{ request('cari') }}">
            <button type="submit" class="btn btn-md btn-primary ml-2">Search</button>
        </form>
    </div>
    <div>
        <a class="btn btn-md btn-success" href="{{ route('admin.siswa.cetak') }}" target="_blank"><i class="fa fa-print"></i> Cetak PDF</a>
    </div>
</div>
<table class="table table-bordered">
    <tr class="font-12">
        <th style="width: 150px">NIS</th>
        <th style="width: 150px">Nama</th>
        <th style="width: 150px">Kelas</th>
        <th style="width: 150px">Tanggal Lahir</th>
        <th style="width: 150px">Alamat</th>
        <th style="width: 150px">Jenis Kelamin</th>
        <th style="width: 150px">TB</th>
        <th style="width: 150px">BB</th>
        <th style="width: 100px">Aksi</th>
    </tr>
    @foreach ($siswa as $data)
    <tr>
        <td style="width: 150px">{{ $data->nis }}</td>
        <td style="width: 150px">{{ $data->users->nama ?? ''}}</td>
        <td style="width: 150px">{{$data->kelas}}</td>
        <td style="width: 150px">{{$data->tanggal_lahir}}</td>
        <td style="width: 150px">{{$data->alamat}}</td>
        <td style="width: 150px">{{$data->jenis_kelamin}}</td>
        <td style="width: 150px">{{$data->tinggi_badan}}</td>
        <td style="width: 150px">{{$data->berat_badan}}</td>
        <td>
            <div class="btn-group" style="width:135px">
                <form action="{{ route('admin.siswa.destroy',$data->id_siswa) }}" method="Post">
                    <a class="btn btn-primary" href="{{ route('admin.siswa.edit',$data->id_siswa) }}">Edit</a>
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
    {!! $siswa->links() !!}
</div>

@endsection