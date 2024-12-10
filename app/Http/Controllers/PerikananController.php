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
        // menampilkan data dari database
        $posts = DB::table('posts')
                    ->select('id','title', 'content', 'created_at')
                    ->get();
        $view_data = [
            'posts' => $posts,
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
        //menerima data
        $title = $request->input('title');
        $content = $request->input('content');

        // insert ke database
        DB::table('posts')->insert([
            'title' => $title,
            'content' => $content,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect('/dashboard/perikanan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {   
        $post = DB::table('posts')
                ->select('id', 'title', 'content', 'created_at')
                ->where('id', '=', $id)
                ->first();
        
        $view_data = [
            'post' => $post
        ];
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
