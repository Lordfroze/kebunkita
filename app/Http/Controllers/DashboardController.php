<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Halaman home
    function index()
    {
        return view('dashboard/index');
    }

    // Halaman setting Perikanan
    function settingkolam()
    {
        return view('dashboard/perikanan/settingkolam');
    }

    //Halaman setting kebun
    function settingkebun()
    {
        return view('dashboard/perkebunan/settingkebun');
    }

    //Halaman setting perdagangan
    function settingbarang()
    {
        return view('dashboard/perdagangan/settingbarang');
    }
}
