@extends('layouts.app')
@section('title')
Detail {{$items->nama_barang}}
@endsection

@section('content')
<div class="container">
        <article class="blog-post">
        <p class="blog-post-meta">{{date("d M Y", strtotime($items->created_at))}}</p>
        <p>Nama Barang : {{$items->nama_barang}}</p>
        <p>Harga Beli : Rp {{ number_format($items->harga_beli, 0, ',', '.') }}</p>
        <p>Harga Jual : Rp {{ number_format($items->harga_jual, 0, ',', '.') }}</p>
        </article>
        <a href="{{ url('/dashboard/perdagangan') }}">Kembali</a>
    </div>
@endsection