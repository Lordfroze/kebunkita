@extends('layouts.app')
@section('title')
Jumlah Ikan
@endsection

@section('content')

@php
$max_ikan_timur = 1500;
$max_ikan_barat = 2500;
$percentageTimur = round(($jumlah_ikan_timur / $max_ikan_timur * 100), 2);
$percentageBarat = round(($jumlah_ikan_barat / $max_ikan_barat * 100), 2);
@endphp
<!-- Main content -->
<div class="info-box">
    <span class="info-box-icon bg-info"><i class="far fa-bookmark"></i></span>
    <div class="info-box-content">
        <span class="info-box-text">Kolam Timur</span>
        <span class="info-box-number">{{$jumlah_ikan_timur}}</span>
        <div class="progress">
            <div class="progress-bar bg-info" style="width: {{$percentageTimur}}%"></div>
        </div>
        <span class="progress-description">
            {{$percentageTimur}} % dari max kapasitas kolam
        </span>
    </div>
</div>

<div class="info-box">
    <span class="info-box-icon bg-info"><i class="far fa-bookmark"></i></span>
    <div class="info-box-content">
        <span class="info-box-text">Kolam Barat</span>
        <span class="info-box-number">{{$jumlah_ikan_barat}}</span>
        <div class="progress">
            <div class="progress-bar bg-info" style="width: {{$percentageBarat}}%"></div>
        </div>
        <span class="progress-description">
            {{$percentageBarat}} % dari max kapasitas kolam
        </span>
    </div>
</div>


@endsection