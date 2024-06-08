@extends('dashboard',[
'title' => 'Tambah Ekstrakulikuler',
'pageTitle' => 'Tambah Ekstrakulikuler'
])
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

<div class="col-lg-8">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Tambah Ekstrakulikuler</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('admin.siswa.save') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="id_pembina">Pilih Pembina</label>
                    <select class="form-control" id="id_pembina" name="id_pembina">
                        <option value="" selected>Pilih Pembina</option>
                        @foreach($pembina as $pemb)
                        <option value="{{ $pemb->id_pembina }}">{{ $pemb->id_pembina }} | {{ $pemb->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="nama_ekskul">Nama Ekskul</label>
                    <input type="text" class="form-control" id="nama_ekskul" name="nama_ekskul">
                </div>
                <div class="form-group">
                    <label for="jml_anggota">Jumlah Anggota</label>
                    <input type="number" class="form-control" id="jml_anggota" name="jml_anggota">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

@endsection