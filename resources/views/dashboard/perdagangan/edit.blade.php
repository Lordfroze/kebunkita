@extends('layouts.app')
@section('title')
Edit Data {{$items->nama_barang}}
@endsection


@section('content')
<div class="content">
    <form method="POST" action="{{ url("dashboard/perdagangan/{$items->id}") }}">  
        @method('PATCH')
        @csrf
        <div class="mb3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" value="{{ $items->created_at->format('Y-m-d') }}">

        </div>
        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama barang</label>
            <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="{{$items->nama_barang}}">
        </div>
        <div class="mb-3">
            <label for="harga_beli" class="form-label">Harga Beli</label>
            <input type="text" class="form-control" id="harga_beli" name="harga_beli" value="{{$items->harga_beli}}">
        </div>
        <div class="mb-3">
            <label for="harga_jual" class="form-label">Harga Jual</label>
            <input type="number" class="form-control" id="harga_jual" rows="3" name="harga_jual" value="{{$items->harga_jual}}">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <button type="submit" class="btn btn-secoundary"><a href="{{url ('dashboard/perdagangan')}}">Kembali</a></button>

    </form>
</div>
@endsection