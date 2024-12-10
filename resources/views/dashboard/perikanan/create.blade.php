@extends('layouts.app')
@section('title')
Buat Postingan Baru
@endsection

@section('content')
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
@endsection