@extends('dashboard', [
    'title' => 'Data Admin',
    'pageTitle' => 'Data Admin',
])
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="d-flex justify-content-between mb-3">
        <div>
            <form action="{{ route('admin.admin') }}" method="GET" class="d-flex">
                <input type="text" name="cari" class="form-control" placeholder="Cari Data" value="{{ request('cari') }}">
                <button type="submit" class="btn btn-md btn-primary ml-2">Search</button>
            </form>
        </div>
        <div>
            <a class="btn btn-md btn-success mr-2" href="{{ route('admin.admin.create') }}"><i class="fa fa-plus"></i>
                Tambah Data</a>
            <a class="btn btn-md btn-success" href="{{ route('admin.admin.cetak') }}" target="_blank"><i
                    class="fa fa-print"></i> Cetak PDF</a>
        </div>
    </div>
    <table class="table table-bordered">
        <tr class="font-12">
            <th style="width: 150px">NIP</th>
            <th style="width: 150px">Nama</th>
            <th style="width: 150px">Tanggal Lahir</th>
            <th style="width: 150px">Tempat Lahir</th>
            <th style="width: 150px">Jenis Kelamin</th>
            <th style="width: 100px">Aksi</th>
        </tr>
        @foreach ($admin as $data)
            <tr>
                <td style="width: 150px">{{ $data->nip }}</td>
                <td style="width: 150px">{{ $data->users->nama ?? '' }}</td>
                <td style="width: 150px">{{ $data->tanggal_lahir }}</td>
                <td style="width: 150px">{{ $data->tempat_lahir }}</td>
                <td style="width: 150px">{{ $data->jenis_kelamin }}</td>
                <td>
                    <div class="btn-group" style="width:135px">
                        <form action="{{ route('admin.admin.destroy', $data->nip) }}" method="POST">
                            <a class="btn btn-primary" href="{{ route('admin.admin.edit', $data->nip) }}">Edit</a>
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
        {!! $admin->links() !!}
    </div>
@endsection
