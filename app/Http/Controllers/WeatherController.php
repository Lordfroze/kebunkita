<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class WeatherController extends Controller
{
    public function getWeather()
    {
        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }
        
        $response = Http::get('https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=35.19.01.2012');
        
        if ($response->successful()) {
            $weatherData = $response->json();
            return view('weather', ['weatherData' => $weatherData]);
        } else {
            return view('weather', ['error' => 'Failed to fetch weather data']);
        }
    }
}
