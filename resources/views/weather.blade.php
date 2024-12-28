@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Weather Information</h1>
    
    @if(isset($error))
        <p class="text-danger">{{ $error }}</p>
    @else
        <h2>Location</h2>
        <ul>
            <li>Provinsi: {{ $weatherData['lokasi']['provinsi'] }}</li>
            <li>Kota: {{ $weatherData['lokasi']['kotkab'] }}</li>
            <li>Kecamatan : {{ $weatherData['lokasi']['kecamatan'] }}</li>
            <li>Desa: {{ $weatherData['lokasi']['desa'] }}</li>
        </ul>

        <!-- menampilkan cuaca -->
        <h2>Cuaca</h2>
        <ul>
        <p>Cuaca: {{ $weatherData['data'][0]['cuaca'][0][0]['weather_desc'] }}</p>

        <img src="{{ $weatherData['data'][0]['cuaca'][0][0]['image'] }}" alt="">

        </ul>

        <h2>Prakiraan cuaca kedepan</h2>

        @foreach($weatherData['data'][0]['cuaca'][0] as $weather)
    <p>Weather Description: {{ $weather['weather_desc'] }}</p>
    <p>Date and Time: {{ $weather['local_datetime'] }}</p>
    <p>Temperature: {{ $weather['t'] }}°C</p>
    <hr>
@endforeach


        
    @endif
</div>
@endsection

<!-- <h2>Raw JSON Data DEBUG</h2>
<pre>{{ json_encode($weatherData, JSON_PRETTY_PRINT) }}</pre> -->
