<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Halaman home
    function index()
    {
        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }
        return view('dashboard/index');
    }

    // Halaman setting Perikanan
    function settingkolam()
    {
        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }
        return view('dashboard/perikanan/settingkolam');
    }

    //Halaman setting kebun
    function settingkebun()
    {
        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }
        return view('dashboard/perkebunan/settingkebun');
    }

    //Halaman setting perdagangan
    function settingbarang()
    {
        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }
        return view('dashboard/perdagangan/settingbarang');
    }
}
