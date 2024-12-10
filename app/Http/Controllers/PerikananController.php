<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class PerikananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        //array uji coba
        // Membaca isi file posts.txt       
        $posts = File::get(storage_path('app/posts.txt')); // mengambil data posts.txt
        $posts = explode("\n", $posts);
        //  ddd($posts);     //untuk dump,die,debug
        $view_data = [
            'posts' => $posts  //mengisi data dari file text                         
        ];

        // Menampilkan view dengan data
        return view('dashboard.perikanan.index', $view_data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // mengarahkan ke halaman create
        return view('dashboard.perikanan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // insert ke database
        DB::table('perikanan')->insert([
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {   
        $posts = File::get(storage_path('app/posts.txt')); //mengambil data posts.txt
        $posts = explode("\n", $posts); // memecah data setiap baris
        $selected_post = Array(); // wadah untuk data
        foreach($posts as $post){   // looping
            $post = explode(",", $post); // memecah data setiap tanda koma
            if($post[0] == $id){  // mengambil data berdasarkan id
                $selected_post = $post; // menyimpan hasil ke $selected_post
            }
        }
        $view_data = [ //array untuk menampilkan hasil
            'post' => $selected_post
        ];

        // return view('posts.show', $view_data); // menampilkan data pada halaman show.blade.php pada folder post

        //
        return view('dashboard.perikanan.show', $view_data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
