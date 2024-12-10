@extends('layouts.app')
@section('title')
Detail Perikanan
@endsection

@section('content')
<div class="container">
    <article class="blog-post">
        <h2 class="blog-post-title mb-1">{{$post[1]}}</h2>
        <p class="blog-post-meta">{{date("d M Y H:i", strtotime($post[3]))}}</p>

        <p>{{$post[2]}}</p>
    </article>
    <a href="{{ url("dashboard/perikanan") }}">Kembali</a>
</div>
@endsection