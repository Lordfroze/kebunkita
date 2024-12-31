@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Weather Information</h1>
<p>BMKG (Badan Meteorologi, Klimatologi, dan Geofisika) </p>
    @if(isset($error))
    <p class="text-danger">{{ $error }}</p>
    @else
    <h2>Location</h2>
    <ul>
        <li>Provinsi: {{ $weatherData['lokasi']['provinsi'] }}</li>
        <li>Kota: {{ $weatherData['lokasi']['kota'] }}</li>
        <li>Kecamatan : {{ $weatherData['lokasi']['kecamatan'] }}</li>
        <li>Desa: {{ $weatherData['lokasi']['desa'] }}</li>
    </ul>

    <!-- menampilkan cuaca -->
    <h2>Prakiraan cuaca</h2>
    @foreach($weatherData['data'][0]['cuaca'][0] as $weather)
    <p>Weather Description: {{ $weather['weather_desc'] }}</p>
    <p>Date and Time: {{ $weather['local_datetime'] }}</p>
    <p>Temperature: {{ $weather['t'] }}°C</p>
    <hr>
    @endforeach
    @endif
</div>
<p>Current Time: {{ date('H:i:s') }}</p>
@endsection


<!-- <h2>Raw JSON Data DEBUG</h2> -->
<!-- <pre>{{ json_encode($weatherData, JSON_PRETTY_PRINT) }}</pre> -->