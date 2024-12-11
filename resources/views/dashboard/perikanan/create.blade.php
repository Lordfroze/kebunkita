@extends('layouts.app')
@section('title')
Tambah Data
@endsection


@section('content')
    <form method="POST" action="{{url ('/dashboard/perikanan')}}" class="form-control">
    @csrf
        <div class="mb-3">
            <label for="kegiatan" class="form-label">Kegiatan</label>
            <input type="text" class="form-control" id="kegiatan" name="kegiatan">
        </div>
        <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi</label>
            <textarea class="form-control" id="lokasi" rows="3" name="lokasi"></textarea>
        </div>
        <div class="mb-3">
            <label for="biaya" class="form-label">Biaya</label>
            <textarea class="form-control" id="biaya" rows="3" name="biaya"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection



<!--  POST  -->
<!-- @section('content')
    <form method="POST" action="{{url ('/dashboard/perikanan')}}" class="form-control">
    @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Konten</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="content"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection -->