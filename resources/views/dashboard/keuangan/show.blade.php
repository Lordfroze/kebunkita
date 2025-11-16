@extends('layouts.app')
@section('title')
Detail {{$task->kegiatan}}
@endsection

@section('content')
<div class="container">
        <article class="blog-post">
        <p class="blog-post-meta">{{date("d M Y", strtotime($task->created_at))}}</p>
        <p>Pemasukan : {{$task->pemasukan}}</p>
        <p>Pengeluaran : {{$task->pengeluaran}}</p>
        </article>

       
        <a href="{{ url('/dashboard/keuangan') }}">Kembali</a>
    </div>
@endsection