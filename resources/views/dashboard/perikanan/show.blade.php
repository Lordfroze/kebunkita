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

        <small class="text-muted">{{$total_comments}} Komentar</small>        
        <!-- Komentar -->
         @foreach($comments as $comment)
         <div class="card mb-3">
            <div class="card-body">
                <p style="font-size: 12pt">{{$comment->comment}}</p>
            </div>
         </div>
         @endforeach
        <a href="{{ url('/dashboard/perikanan') }}">Kembali</a>
    </div>
@endsection