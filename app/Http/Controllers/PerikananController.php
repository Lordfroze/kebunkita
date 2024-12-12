<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;


class PerikananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   

        // tampilkan table perikanan
        $tasks = DB::table('perikanan')
                    ->select('id','created_at', 'kegiatan', 'lokasi', 'biaya',)
                    ->get();

        // tampilkan total biaya
        $totalBiaya = DB::table('perikanan')->sum('biaya');

        // tampilkan table posts
        $posts = DB::table('posts')
                    ->select('id','title', 'content', 'created_at')
                    ->get();
        
        // Membuat array untuk menyimpan data
        $view_data = [
            'posts' => $posts,
            'tasks' => $tasks,
            'totalBiaya' => $totalBiaya,
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
        // Menerima data dari create.blade.php untuk perikanan
        $kegiatan = $request->input('kegiatan');
        $lokasi = $request->input('lokasi');
        $biaya = $request->input('biaya');

        // insert ke database perikanan
        DB::table('perikanan')->insert([
            'kegiatan' => $kegiatan,
            'lokasi' => $lokasi,
            'biaya' => $biaya,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        //menerima data dari create.blade.php untuk post
        // $title = $request->input('title');
        // $content = $request->input('content');

        // insert ke database post
        // DB::table('posts')->insert([
        //     'title' => $title,
        //     'content' => $content,
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s'),
        // ]);

        return redirect('/dashboard/perikanan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {   
        // menampilkan data setiap id perikanan dari database
        $task = DB::table('perikanan')
                ->select('id', 'kegiatan', 'lokasi', 'biaya','created_at')
                ->where('id', '=', $id)
                ->first();


        // Tampilkan table posts
        // $post = DB::table('posts')
        //         ->select('id', 'title', 'content', 'created_at')
        //         ->where('id', '=', $id)
        //         ->first();
        
        $view_data = [
            'task' => $task,
            // 'post' => $post,

        ];

        return view('dashboard.perikanan.show', $view_data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // mengedit database
        $task = DB::table('perikanan')
                ->select('id', 'kegiatan', 'lokasi', 'biaya','created_at')
                ->where('id', '=', $id)
                ->first();
        
        $view_data = [
            'task' => $task,
        ];
        return view('dashboard.perikanan.edit', $view_data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    // mengambil data dari form edit
    $kegiatan = $request->input('kegiatan');
    $lokasi = $request->input('lokasi');
    $biaya = $request->input('biaya');

    // UPDATE ... WHERE id = $id
    DB::table('perikanan')
        ->where('id', $id)  // Gunakan $id langsung
        ->update([
            'kegiatan' => $kegiatan,
            'lokasi' => $lokasi,
            'biaya' => $biaya,
            'updated_at' => now()
        ]);

    return redirect("dashboard/perikanan/{$id}");
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
