<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Perikanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Exports\DataExport;
use Maatwebsite\Excel\Facades\Excel;


class PerikananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }
        // tampilkan table perikanan
        $tasks = Perikanan::where('active', '=', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

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

        // tampilkan jumlah ikan
        $jumlahIkan = Perikanan::sum('jumlah_ikan');

        // tampilkan jumlah ikan kolam timur
        $jumlah_ikan_timur = Perikanan::where('lokasi', 'like', '%kolam timur%')
            ->sum('jumlah_ikan');

        // tampilkan jumlah ikan kolam barat
        $jumlah_ikan_barat = Perikanan::where('lokasi', 'like', '%kolam barat%')
            ->sum('jumlah_ikan');

        // Membuat array untuk menyimpan data
        $view_data = [
            'posts' => $posts,
            'tasks' => $tasks,
            'totalBiaya' => $totalBiaya,
            'jumlahPakanKolamTimur' => $jumlahPakanKolamTimur,
            'jumlahPakanKolamBarat' => $jumlahPakanKolamBarat,
            'jumlahIkan' => $jumlahIkan,
            'jumlah_ikan_timur' => $jumlah_ikan_timur,
            'jumlah_ikan_barat' => $jumlah_ikan_barat,
        ];

        // Menampilkan view dengan data
        return view('dashboard.perikanan.index', $view_data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }

        // Mendapatkan musim panen terbaru berdasrkan lokasi yang dipilih
        $latestMusimPanen = Perikanan::select('lokasi')
            ->selectRaw('MAX(musim_panen) as latest_musim_panen')
            ->groupBy('lokasi')
            ->pluck('latest_musim_panen', 'lokasi')
            ->toArray();

        // mengarahkan ke halaman create
        return view('dashboard.perikanan.create', compact('latestMusimPanen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }
        // Menerima data dari create.blade.php untuk perikanan

        $tanggal = $request->input('tanggal') ?? now()->toDateString(); // Set tanggal to current date if not provided
        $lokasi = $request->input('lokasi');
        $biaya = $request->input('biaya');
        $musim_panen = $request->input('musim_panen');
        $kegiatan = $request->input('kegiatan') == 'other' ? $request->input('kegiatan_other') : $request->input('kegiatan');

        // set rubah ikan ke 0
        $fish_count_change = 0;

        // Proses kurangi ikan jika kegiatan adalah 'kurangi ikan'
        if (strtolower($kegiatan) == 'kurangi ikan') {
            $kurangi_ikan_input = $request->input('kurangi_ikanInput');

            // Ensure we're working with a numeric value
            $kurangi_ikan_input = is_numeric($kurangi_ikan_input) ? floatval($kurangi_ikan_input) : 0;

            $fish_count_change = -abs($kurangi_ikan_input);

            // Update the total fish count in the database
            try {
                $affected = Perikanan::where('id', $id)->decrement('jumlah_ikan', abs($fish_count_change));
            } catch (\Exception $e) {
                // Handle the error silently or add appropriate error handling
            }
        } elseif (strtolower($kegiatan) == 'tambah ikan') {
            $fish_count_change = abs($request->input('tambah_ikanInput', 0));
        }

        // create ke database perikanan
        $task = Perikanan::create([
            'kegiatan' => $kegiatan,
            'lokasi' => $lokasi,
            'biaya' => $biaya,
            'created_at' => $tanggal,
            'updated_at' => now(), //     'updated_at' => date('Y-m-d H:i:s'),
            'musim_panen' => $musim_panen,
            'jumlah_ikan' => $fish_count_change,
        ]);
        
        // kirim telegram setelah menyimpan data
        $this->notify_telegram($task);  // agar tidak terlalu panjang dipisah ke fungsi notify_telegram dibawah

        return redirect('/dashboard/perikanan')->with('success', 'Data Sukses Ditambahkan');
    }

    private function notify_telegram($task)
    {   
        // fungsi untuk mengirimkan notifikasi ke telegram
        $api_token = "masukkantoken";
        $url = "https://api.telegram.org/bot{$api_token}/sendMessage";
        $chat_id = -1002381690269;
        $content = 
        "Ada kegiatan terbaru : <strong> \"{$task->kegiatan}\" </strong>
        \nLokasi : <strong> \"{$task->lokasi}\" </strong>
        \nTanggal : <strong> \"{$task->created_at}\" </strong>";


        $data = [
            'chat_id' => $chat_id,
            'text' => $content,
            'parse_mode' => 'html',
        ];

        Http::Post($url, $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }
        // menampilkan data setiap id perikanan dari database
        $task = Perikanan::select('id', 'kegiatan', 'lokasi', 'biaya', 'created_at')
            ->where('id', '=', $id)
            ->first();

        $comments = $task->comments()->limit(5)->get(); // menampilkan comment dengan limit 2
        $total_comments = $task->total_comments(); // menampilkan total comment dari model perikanan

        // Tampilkan table posts
        // $post = DB::table('posts')
        //         ->select('id', 'title', 'content', 'created_at')
        //         ->where('id', '=', $id)
        //         ->first();

        $view_data = [
            'task' => $task,
            'comments' => $comments,
            'total_comments' => $total_comments,
            // 'post' => $post,

        ];

        return view('dashboard.perikanan.show', $view_data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }
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
        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }
        // mengambil data dari form edit
        $tanggal = $request->input('tanggal');
        $kegiatan = $request->input('kegiatan');
        $lokasi = $request->input('lokasi');
        $biaya = $request->input('biaya');
        $musim_panen = $request->input('musim_panen');

        // UPDATE ... WHERE id = $id
        Perikanan::where('id', $id)  // Gunakan $id langsung
            ->update([
                'created_at' => $tanggal,
                'kegiatan' => $kegiatan,
                'lokasi' => $lokasi,
                'biaya' => $biaya,
                'updated_at' => now(),
                'musim_panen' => $musim_panen,
            ]);

        return redirect("dashboard/perikanan/{$id}");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }
        // menghapus data dari database
        Perikanan::where('id', $id)
            ->delete();

        return redirect("dashboard/perikanan/");
    }

    // HALAMAN KOLAM TIMUR
    public function kolam_timur()
    {
        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }
        // tampilkan table perikanan
        $tasks = Perikanan::select('id', 'created_at', 'kegiatan', 'lokasi', 'biaya',)
            ->where('lokasi', 'like', '%kolam timur%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // tampilkan total biaya seluruh kolam
        $totalBiaya = Perikanan::sum('biaya');

        // tampilkan total biaya kolam timur
        $totalBiayaKolamTimur = Perikanan::where('lokasi', 'like', '%kolam timur%')
            ->sum('biaya');

        // tampilkan biaya panen kolam timur
        $totalBiayaKolamTimurPanen = Perikanan::where('lokasi', 'like', '%kolam timur%')
            ->where('kegiatan', 'like', '%panen%')
            ->sum('biaya');

        // tampilkan jumlah pakan kolam timur
        $jumlahPakanKolamTimur = Perikanan::where('kegiatan', 'like', '%beli pakan%')
            ->where('lokasi', 'like', '%kolam timur%')
            ->count();

        // tampilkan jumlah ikan kolam timur
        $jumlah_ikan_timur = Perikanan::where('lokasi', 'like', '%kolam timur%')
            ->sum('jumlah_ikan');

        // chart
        $chartData = $this->getChartDataTimur();

        // Membuat array untuk menyimpan data
        $view_data = [
            'tasks' => $tasks,
            'totalBiaya' => $totalBiaya,
            'jumlahPakanKolamTimur' => $jumlahPakanKolamTimur,
            'totalBiayaKolamTimur' => $totalBiayaKolamTimur,
            'jumlah_ikan_timur' => $jumlah_ikan_timur,
            'chartData' => $chartData,
            'totalBiayaKolamTimurPanen' => $totalBiayaKolamTimurPanen,
        ];

        return view('dashboard.perikanan.kolam_timur.kolamtimur', $view_data);
    }

    // mempersiapkan data untuk chart
    private function getChartDataTimur()
    {
        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }
        $data = Perikanan::where('lokasi', 'Kolam Timur')
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
        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }
        try {
            // Delete all records from the perikanan table where lokasi is 'Kolam Timur'
            $deletedCount = Perikanan::select('id', 'created_at', 'kegiatan', 'lokasi', 'biaya',)
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

    // HALAMAN KOLAM BARAT
    public function kolam_barat()
    {
        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }
        // tampilkan table perikanan
        $tasks = Perikanan::select('id', 'created_at', 'kegiatan', 'lokasi', 'biaya',)
            ->where('lokasi', 'like', '%kolam barat%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // tampilkan total biaya kolam barat
        $totalBiayaKolamBarat = Perikanan::where('lokasi', 'like', '%kolam barat%')
            ->sum('biaya');

        // tampilkan jumlah biaya panen kolam barat
        $totalBiayaPanenKolamBarat = Perikanan::where('lokasi', 'like', '%kolam barat%')
            ->where('kegiatan', 'like', '%panen%')
            ->sum('biaya');

        // tampilkan jumlah pakan kolam barat
        $jumlahPakanKolamBarat = Perikanan::where('kegiatan', 'like', '%beli pakan%')
            ->where('lokasi', 'like', '%kolam barat%')
            ->count();

        // tampilkan jumlah ikan kolam barat
        $jumlah_ikan_barat = Perikanan::where('lokasi', 'like', '%kolam barat%')
            ->sum('jumlah_ikan');

        // chart
        $chartData = $this->getChartDataBarat();

        // Membuat array untuk menyimpan data
        $view_data = [
            'tasks' => $tasks,
            'jumlahPakanKolamBarat' => $jumlahPakanKolamBarat,
            'totalBiayaKolamBarat' => $totalBiayaKolamBarat,
            'jumlah_ikan_barat' => $jumlah_ikan_barat,
            'chartData' => $chartData,
            'totalBiayaPanenKolamBarat' => $totalBiayaPanenKolamBarat,
        ];

        return view('dashboard.perikanan.kolam_barat.kolambarat', $view_data);
    }

    // mempersiapkan data untuk chart kolam barat
    private function getChartDataBarat()
    {
        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }
        $data = Perikanan::where('lokasi', 'kolam barat')
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

    public function deleteAllKolamBarat()
    {
        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }
        try {
            // Delete all records from the perikanan table where lokasi is 'Kolam Barat'
            $deletedCount = Perikanan::select('id', 'created_at', 'kegiatan', 'lokasi', 'biaya',)
                ->where('lokasi', 'like', '%kolam barat%')
                ->delete();


            if ($deletedCount > 0) {
                return redirect("dashboard/perikanan/")->with('success', "All perikanan data for Kolam Barat has been successfully deleted. ($deletedCount records removed)");
            } else {
                return redirect("dashboard/perikanan/")->with('info', 'No perikanan data found for Kolam Barat to delete.');
            }
        } catch (\Exception $e) {
            // If an error occurs, redirect back with an error message
            return redirect("dashboard/perikanan/")->with('error', 'An error occurred while deleting perikanan data: ' . $e->getMessage());
        }
    }

    // Tampilkan data jumlah ikan pada setiap kolam
    public function jumlah_ikan()
    {
        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }
        // tampilkan jumlah ikan kolam timur
        $jumlah_ikan_timur = Perikanan::where('lokasi', 'like', '%kolam timur%')
            ->sum('jumlah_ikan');

        // tampilkan jumlah ikan kolam barat
        $jumlah_ikan_barat = Perikanan::where('lokasi', 'like', '%kolam barat%')
            ->sum('jumlah_ikan');

        // Membuat array untuk menyimpan data
        $view_data = [
            'jumlah_ikan_timur' => $jumlah_ikan_timur,
            'jumlah_ikan_barat' => $jumlah_ikan_barat,
            // 'chartData' => $chartData,
        ];

        return view('dashboard.perikanan.jumlah_ikan.jumlahikan', $view_data);
    }

    // Tampilkan data setiap musim panen
    public function musim_panen($season)
    {
        $tasks = Perikanan::where('musim_panen', $season)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalBiaya = Perikanan::where('musim_panen', $season)->sum('biaya');
        $jumlahIkan = Perikanan::where('musim_panen', $season)->sum('jumlah_ikan');

        return view('dashboard.perikanan.musim_panen', compact('tasks', 'totalBiaya', 'jumlahIkan', 'season'));
    }

    // Fungsi download
    public function downloadExcel()
    {
        return Excel::download(new DataExport, 'data.xlsx');
    }
}
