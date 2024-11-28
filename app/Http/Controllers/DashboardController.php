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
    function tabel_ikan(){
        return view('dashboard/perikanan/tabel_ikan');
    }
}
