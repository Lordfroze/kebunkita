@extends('layouts.app')
@section('title')
@endsection
@section('content')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Download Data</h3>
                    </div>
                    <div class="card-body">
                        <div class="card card-outline card-primary">
                            <a class="btn btn-success" href="{{ url('http://kebunkita.localhost/download-excel?lokasi_like=Kolam%20Timur') }}"> Download Data Kolam Timur</a>
                        </div>
                        <div class="card card-outline card-primary">
                            <a class="btn btn-success" href="{{ url('http://kebunkita.localhost/download-excel?lokasi_like=Kolam%20Barat') }}"> Download Data Kolam Barat</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection