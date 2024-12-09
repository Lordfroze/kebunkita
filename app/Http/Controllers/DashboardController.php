<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Halaman home
    function index(){
        return view('dashboard/index');
    }

    // Halaman tabel ikan
    function perikanan(){
        return view('dashboard/perikanan/index');
    }

    // Halaman tabel perdagangan
    function perdagangan(){
        return view('dashboard/perdagangan/index');
    }

    // Halaman tabel perkebunan
    function perkebunan(){
        return view('dashboard/perkebunan/index');
    }

}