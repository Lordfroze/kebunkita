@extends('layouts.app')
@section('title')
Edit Data
@endsection


@section('content')
<div class="content">
    <form method="POST" action="{{ url("dashboard/perikanan/{$task->id}") }}">
        @method('PATCH')
        @csrf
        <div class="mb-3">
            <label for="kegiatan" class="form-label">Kegiatan</label>
            <input type="text" class="form-control" id="kegiatan" name="kegiatan" value="{{$task->kegiatan}}">
        </div>
        <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi</label>
            <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{$task->lokasi}}">
        </div>
        <div class="mb-3">
            <label for="biaya" class="form-label">Biaya</label>
            <input type="number" class="form-control" id="biaya" rows="3" name="biaya" value="{{$task->biaya}}">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection