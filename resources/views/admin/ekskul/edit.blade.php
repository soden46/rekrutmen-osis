@extends('dashboard',[
'title' => 'Edit Ekstrakulikuler',
'pageTitle' => 'Edit Ekstrakulikuler'
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
            <h5 class="card-title">Edit Ekstrakulikuler</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('admin.ekskul.update',$ekskul->id_ekskul) }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="id_pembina">Pilih Pembina</label>
                    <select class="form-control" id="id_pembina" name="id_pembina">
                        <option value="" selected>Pilih Pembina</option>
                        @foreach($pembina as $pemb)
                        <option value="{{ $pemb->id_pembina }}" {{ $ekskul->id_pembina == $pemb->id_pembina ? 'selected' : '' }}>
                            {{ $pemb->id_pembina }} | {{ $pemb->nama }}
                            @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="nama_ekskul">Nama Ekskul</label>
                    <input type="text" class="form-control" id="nama_ekskul" name="nama_ekskul" value="{{$ekskul->nama_ekskul}}">
                </div>
                <div class="form-group">
                    <label for="jml_anggota">Jumlah Anggota</label>
                    <input type="number" class="form-control" id="jml_anggota" name="jml_anggota" value="{{$ekskul->nama_ekskul}}">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

@endsection