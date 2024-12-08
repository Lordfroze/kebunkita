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
    function settingkolam(){
        return view('dashboard/perikanan/settingkolam');
    }

    //Halaman kebun
    function settingkebun(){
        return view('dashboard/perkebunan/settingkebun');
    }

    // Halaman app
    function app(){
        return view('layouts/app');
    }
}