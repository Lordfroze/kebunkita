@extends('layouts.app')
@section('title')
Detail {{$task->kegiatan}}
@endsection

@section('content')
<div class="container">
        <article class="blog-post">
        <p class="blog-post-meta">{{date("d M Y", strtotime($task->created_at))}}</p>
        <p>Kegiatan : {{$task->kegiatan}}</p>
        <p>Lokasi : {{$task->lokasi}}</p>
        <p>Biaya : {{$task->biaya}}</p>
        </article>
        <a href="{{ url('/dashboard/perikanan') }}">Kembali</a>
    </div>
@endsection