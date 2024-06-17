@extends('dashboard',[
'title' => 'Tambah Rekrutmen',
'pageTitle' => 'Tambah Rekrutmen'
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
            <h5 class="card-title">Tambah Rekrutmen</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('pembina.rekrutmen.save') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="id_ekskul">Pilih Ekskul</label>
                    <select class="form-control" id="id_ekskul" name="id_ekskul">
                        <option value="" selected>Pilih Ekskul</option>
                        @foreach($ekskul as $data)
                        <option value="{{ $data->id_ekskul }}">{{ $data->id_ekskul }} | {{ $data->nama_ekskul }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="nama_rekrutmen">Nama Rekrutmen</label>
                    <input type="text" class="form-control" id="nama_rekrutmen" name="nama_rekrutmen">
                </div>
                <div class="form-group">
                    <label for="tanggal_dimulai">tanggal_dimulai</label>
                    <input type="date" class="form-control" id="tanggal_dimulai" name="tanggal_dimulai">
                </div>
                <div class="form-group">
                    <label for="tanggal_berakhir">tanggal_berakhir</label>
                    <input type="date" class="form-control" id="tanggal_berakhir" name="tanggal_berakhir">
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <input id="deskripsi" type="hidden" name="deskripsi">
                    <trix-editor input="deskripsi"></trix-editor>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/33.1.1/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create(document.querySelector('#keterangan'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection