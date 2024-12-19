<?php

namespace App\Http\Controllers;

use App\Models\Perikanan;
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
        $tasks = Perikanan::where('active', '=', true)->paginate(10);
        
        // tampilkan dengan data yang sudah didelete
        // $tasks = Perikanan::where('active', '=', true)->withTrashed()->paginate(10);


        // tampilkan total biaya
        $totalBiaya = Perikanan::sum('biaya');

        // tampilkan table posts
        $posts = DB::table('posts')
            ->select('id', 'title', 'content', 'created_at')
            ->get();

        // tampilkan jumlah pakan kolam timur
        $jumlahPakanKolamTimur = Perikanan::where('kegiatan', 'like', '%beli pakan%')
            ->where('lokasi', 'like', '%kolam timur%')
            ->count();

        // tampilkan jumlah pakan kolam barat
        $jumlahPakanKolamBarat = Perikanan::where('kegiatan', 'like', '%beli pakan%')
            ->where('lokasi', 'like', '%kolam barat%')
            ->count();

        // Membuat array untuk menyimpan data
        $view_data = [
            'posts' => $posts,
            'tasks' => $tasks,
            'totalBiaya' => $totalBiaya,
            'jumlahPakanKolamTimur' => $jumlahPakanKolamTimur,
            'jumlahPakanKolamBarat' => $jumlahPakanKolamBarat,
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

        $tanggal = $request->input('tanggal') ?? now()->toDateString(); // Set tanggal to current date if not provided
        $lokasi = $request->input('lokasi');
        $biaya = $request->input('biaya');

        $kegiatan = $request->input('kegiatan') == 'other' ? $request->input('kegiatan_other') : $request->input('kegiatan');

        // insert ke database perikanan
        Perikanan::insert([
            'kegiatan' => $kegiatan,
            'lokasi' => $lokasi,
            'biaya' => $biaya,
            'created_at' => $tanggal,
            'updated_at' => now(), //     'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect('/dashboard/perikanan')->with('success', 'Data Sukses Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // menampilkan data setiap id perikanan dari database
        $task = Perikanan::select('id', 'kegiatan', 'lokasi', 'biaya', 'created_at')
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
        $task = Perikanan::select('id', 'kegiatan', 'lokasi', 'biaya', 'created_at')
            ->where('id', '=', $id)
            ->first();

        // Convert created_at to Carbon instance
        $task->created_at = Carbon::parse($task->created_at);

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
        $tanggal = $request->input('tanggal');
        $kegiatan = $request->input('kegiatan');
        $lokasi = $request->input('lokasi');
        $biaya = $request->input('biaya');

        // UPDATE ... WHERE id = $id
        Perikanan::where('id', $id)  // Gunakan $id langsung
            ->update([
                'created_at' => $tanggal,
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
        // menghapus data dari database
        Perikanan::where('id', $id)
            ->delete();

        return redirect("dashboard/perikanan/");
    }

    // tampilkan data kolam timur
    public function kolam_timur()
    {
        // tampilkan table perikanan
        $tasks = Perikanan::select('id', 'created_at', 'kegiatan', 'lokasi', 'biaya',)
            ->where('lokasi', 'like', '%kolam timur%')
            ->paginate(10);

        // tampilkan total biaya seluruh kolam
        $totalBiaya = Perikanan::sum('biaya');

        // tampilkan total biaya kolam timur
        $totalBiayaKolamTimur = Perikanan::where('lokasi', 'like', '%kolam timur%')
            ->sum('biaya');

        // tampilkan jumlah pakan kolam timur
        $jumlahPakanKolamTimur = Perikanan::where('kegiatan', 'like', '%beli pakan%')
            ->where('lokasi', 'like', '%kolam timur%')
            ->count();

        // chart
        $chartData = $this->getChartData();

        // Membuat array untuk menyimpan data
        $view_data = [
            'tasks' => $tasks,
            'totalBiaya' => $totalBiaya,
            'jumlahPakanKolamTimur' => $jumlahPakanKolamTimur,
            'totalBiayaKolamTimur' => $totalBiayaKolamTimur,
            'chartData' => $chartData,
        ];

        return view('dashboard.perikanan.kolam_timur.kolamtimur', $view_data);
    }

    // mempersiapkan data untuk chart
        private function getChartData()
        {
            $data = Perikanan::
                where('lokasi', 'Kolam Timur')
                ->select(Perikanan::raw('MONTH(created_at) as month'), Perikanan::raw('SUM(biaya) as total'))
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $labels = [];
            $values = [];

            foreach ($data as $item) {
                $labels[] = date('F', mktime(0, 0, 0, $item->month, 1));
                $values[] = $item->total;
            }

            return [
                'labels' => $labels,
                'data' => $values,
            ];
        }

    public function deleteAllKolamTimur()
    {
        try {
            // Delete all records from the perikanan table where lokasi is 'Kolam Timur'
            $deletedCount = Perikanan::
                select('id', 'created_at', 'kegiatan', 'lokasi', 'biaya',)
                ->where('lokasi', 'like', '%kolam timur%')
                ->delete();


            if ($deletedCount > 0) {
                return redirect("dashboard/perikanan/")->with('success', "All perikanan data for Kolam Timur has been successfully deleted. ($deletedCount records removed)");
            } else {
                return redirect("dashboard/perikanan/")->with('info', 'No perikanan data found for Kolam Timur to delete.');
            }
        } catch (\Exception $e) {
            // If an error occurs, redirect back with an error message
            return redirect("dashboard/perikanan/")->with('error', 'An error occurred while deleting perikanan data: ' . $e->getMessage());
        }
    }
}
