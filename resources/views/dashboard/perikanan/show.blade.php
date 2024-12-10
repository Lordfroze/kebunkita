@extends('layouts.app')
@section('title')
Detail Perikanan
@endsection

@section('content')
<div class="container">
        <article class="blog-post">
        <h2 class="blog-post-title mb-1">{{$post->title}}</h2>
        <p class="blog-post-meta">{{date("d M Y H:i", strtotime($post->created_at))}}</p>

        <p>{{$post->content}}</p>
        </article>
        <a href="{{ url('/dashboard/perikanan') }}">Kembali</a>
    </div>
@endsection