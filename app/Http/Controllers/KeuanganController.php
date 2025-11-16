<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Exports\DataExport;
use GuzzleHttp\Psr7\Query;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KeuanganExport;


class KeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }
        // tampilkan table keuangan`
        $tasks = Keuangan::where('active', '=', true)
            ->orderBy('created_at', 'desc');

        // Ambil input dari query string
        $start = $request->input('start_date');
        $end   = $request->input('end_date');

        // Jika ada filter, tambahkan ke query
        if ($start && $end) {
            $tasks = $tasks->whereBetween('created_at', [$start, $end]);
        }

        // tampilkan total pemasukan
        $totalPemasukan = $tasks->clone()->sum('pemasukan');

        // tampilkan total pengeluaran
        $totalPengeluaran = $tasks->clone()->sum('pengeluaran');

        // tampilkan total keseluruhan
        $totalKeseluruhan = $tasks->clone()->sum(Keuangan::raw('pemasukan - pengeluaran'));

        // paginate data
        $tasks = $tasks->paginate(10);


        // tampilkan dengan data yang sudah didelete
        // $tasks = Perikanan::where('active', '=', true)->withTrashed()->paginate(10);


        // tampilkan total biaya kecuali panen
        // $totalBiaya = Keuangan::where('kegiatan', 'not like', '%panen%')
        // ->sum('biaya');

        // tampilkan table posts
        // $posts = DB::table('posts')
        //     ->select('id', 'title', 'content', 'created_at')
        //     ->get();

        // Membuat array untuk menyimpan data
        $view_data = [
            'tasks' => $tasks,
            'totalKeseluruhan' => $totalKeseluruhan,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
        ];

        // Menampilkan view dengan data
        return view('dashboard.keuangan.index', $view_data);
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

        // mengarahkan ke halaman create
        return view('dashboard.keuangan.create');
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
        // Menerima data dari create.blade.php untuk Keuangan
        $tanggal = $request->input('tanggal') ?? now()->toDateString(); // Set tanggal to current date if not provided
        $pemasukan = $request->input('pemasukan');
        $pengeluaran = $request->input('pengeluaran');

        // create ke database Keuangan
        $task = Keuangan::create([
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'created_at' => $tanggal,
            'updated_at' => now(), //     'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // kirim telegram setelah menyimpan data
        $this->notify_telegram($task);  // agar tidak terlalu panjang dipisah ke fungsi notify_telegram dibawah

        return redirect('/dashboard/keuangan')->with('success', 'Data Sukses Ditambahkan');
    }

    private function notify_telegram($task)
    {
        // fungsi untuk mengirimkan notifikasi ke telegram
        $api_token = "7356494066:AAE1knM0q6coNEbitf27Xxl8pgeJl3xYcoI";
        $url = "https://api.telegram.org/bot{$api_token}/sendMessage";
        $chat_id = 1118682327;  // untuk kirim ke group telegram tambahkan tanda minus didepan (-) dan id group telegram
        // $chat_id = -1001941234567; // untuk kirim ke group telegram tambahkan - dan id group telegram

        $content =
            "Ada kegiatan terbaru : <strong> \"{$task->kegiatan}\" </strong>
        \nLokasi : <strong> \"{$task->lokasi}\" </strong>
        \nTanggal : <strong> \"{$task->created_at}\" </strong>";


        $data = [
            'chat_id' => $chat_id,
            'text' => $content,
            'parse_mode' => 'html',
        ];

        $response = Http::Post($url, $data);
        if (!$response->successful()) {
            \Log::error('Telegram notification failed', ['response' => $response->body()]);
        }
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
        // menampilkan data setiap id Keuangan dari database
        $task = Keuangan::select('id', 'pemasukan', 'pengeluaran', 'created_at')
            ->where('id', '=', $id)
            ->first();

        // $comments = $task->comments()->limit(5)->get(); // menampilkan comment dengan limit 2
        // $total_comments = $task->total_comments(); // menampilkan total comment dari model Keuangan

        // Tampilkan table posts
        // $post = DB::table('posts')
        //         ->select('id', 'title', 'content', 'created_at')
        //         ->where('id', '=', $id)
        //         ->first();

        $view_data = [
            'task' => $task,
            // 'comments' => $comments,
            // 'total_comments' => $total_comments,
            // 'post' => $post,

        ];

        return view('dashboard.keuangan.show', $view_data);
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
        $task = Keuangan::select('id', 'pemasukan', 'pengeluaran', 'created_at')
            ->where('id', '=', $id)
            ->first();

        // Convert created_at to Carbon instance
        $task->created_at = Carbon::parse($task->created_at);

        $view_data = [
            'task' => $task,
        ];
        return view('dashboard.keuangan.edit', $view_data);
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
        $pemasukan = $request->input('pemasukan');
        $pengeluaran = $request->input('pengeluaran');

        // UPDATE ... WHERE id = $id
        Keuangan::where('id', $id)  // Gunakan $id langsung
            ->update([
                'created_at' => $tanggal,
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
                'updated_at' => now(),
            ]);

        return redirect("dashboard/keuangan/{$id}");
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
        Keuangan::where('id', $id)
            ->delete();

        return redirect("dashboard/keuangan/");
    }

    // HALAMAN KOLAM TIMUR
    public function kolam_timur()
    {
        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }
        // tampilkan table Keuangan
        $tasks = Keuangan::select('id', 'created_at', 'kegiatan', 'lokasi', 'biaya',)
            ->where('lokasi', 'like', '%kolam timur%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // tampilkan total biaya seluruh kolam
        // $totalBiaya = Keuangan::sum('biaya');

        // tampilkan total biaya kolam timur kecuali panen
        $totalBiayaKolamTimur = Keuangan::where('lokasi', 'like', '%kolam timur%')
            ->where('kegiatan', 'not like', '%panen%')
            ->sum('biaya');


        // tampilkan biaya panen kolam timur
        $totalBiayaKolamTimurPanen = Keuangan::where('lokasi', 'like', '%kolam timur%')
            ->where('kegiatan', 'like', '%panen%')
            ->sum('biaya');

        // tampilkan selisih panen dan biaya kolam timur dan panen
        $selisihBiayaPanen = $totalBiayaKolamTimurPanen - $totalBiayaKolamTimur;

        // tampilkan jumlah pakan kolam timur
        $jumlahPakanKolamTimur = Keuangan::where('kegiatan', 'like', '%beli pakan%')
            ->where('lokasi', 'like', '%kolam timur%')
            ->count();

        // tampilkan jumlah ikan kolam timur
        $jumlah_ikan_timur = Keuangan::where('lokasi', 'like', '%kolam timur%')
            ->sum('jumlah_ikan');

        // chart
        $chartData = $this->getChartDataTimur();

        // Membuat array untuk menyimpan data
        $view_data = [
            'tasks' => $tasks,
            // 'totalBiaya' => $totalBiaya,
            'jumlahPakanKolamTimur' => $jumlahPakanKolamTimur,
            'totalBiayaKolamTimur' => $totalBiayaKolamTimur,
            'jumlah_ikan_timur' => $jumlah_ikan_timur,
            'chartData' => $chartData,
            'totalBiayaKolamTimurPanen' => $totalBiayaKolamTimurPanen,
            'selisihBiayaPanen' => $selisihBiayaPanen
        ];

        return view('dashboard.Keuangan.kolam_timur.kolamtimur', $view_data);
    }

    // mempersiapkan data untuk chart
    private function getChartDataTimur()
    {
        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }
        $data = Keuangan::where('lokasi', 'Kolam Timur')
            ->select(Keuangan::raw('MONTH(created_at) as month'), Keuangan::raw('SUM(biaya) as total'))
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
            // Delete all records from the Keuangan table where lokasi is 'Kolam Timur'
            $deletedCount = Keuangan::select('id', 'created_at', 'kegiatan', 'lokasi', 'biaya',)
                ->where('lokasi', 'like', '%kolam timur%')
                ->delete();


            if ($deletedCount > 0) {
                return redirect("dashboard/Keuangan/")->with('success', "All Keuangan data for Kolam Timur has been successfully deleted. ($deletedCount records removed)");
            } else {
                return redirect("dashboard/Keuangan/")->with('info', 'No Keuangan data found for Kolam Timur to delete.');
            }
        } catch (\Exception $e) {
            // If an error occurs, redirect back with an error message
            return redirect("dashboard/Keuangan/")->with('error', 'An error occurred while deleting Keuangan data: ' . $e->getMessage());
        }
    }

    // HALAMAN KOLAM BARAT
    public function kolam_barat()
    {
        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }
        // tampilkan table Keuangan
        $tasks = Keuangan::select('id', 'created_at', 'kegiatan', 'lokasi', 'biaya',)
            ->where('lokasi', 'like', '%kolam barat%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // tampilkan total biaya kolam barat
        $totalBiayaKolamBarat = Keuangan::where('lokasi', 'like', '%kolam barat%')
            ->where('kegiatan', 'not like', '%panen%')
            ->sum('biaya');

        // tampilkan jumlah biaya panen kolam barat
        $totalBiayaPanenKolamBarat = Keuangan::where('lokasi', 'like', '%kolam barat%')
            ->where('kegiatan', 'like', '%panen%')
            ->sum('biaya');

        // tampilkan selisih biaya panen dan biaya kolam barat
        $selisihBiayaPanen = $totalBiayaPanenKolamBarat - $totalBiayaKolamBarat;

        // tampilkan jumlah pakan kolam barat
        $jumlahPakanKolamBarat = Keuangan::where('kegiatan', 'like', '%beli pakan%')
            ->where('lokasi', 'like', '%kolam barat%')
            ->count();

        // tampilkan jumlah ikan kolam barat
        $jumlah_ikan_barat = Keuangan::where('lokasi', 'like', '%kolam barat%')
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
            'selisihBiayaPanen' => $selisihBiayaPanen
        ];

        return view('dashboard.Keuangan.kolam_barat.kolambarat', $view_data);
    }

    // mempersiapkan data untuk chart kolam barat
    private function getChartDataBarat()
    {
        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }
        $data = Keuangan::where('lokasi', 'kolam barat')
            ->select(Keuangan::raw('MONTH(created_at) as month'), Keuangan::raw('SUM(biaya) as total'))
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
            // Delete all records from the Keuangan table where lokasi is 'Kolam Barat'
            $deletedCount = Keuangan::select('id', 'created_at', 'kegiatan', 'lokasi', 'biaya',)
                ->where('lokasi', 'like', '%kolam barat%')
                ->delete();


            if ($deletedCount > 0) {
                return redirect("dashboard/Keuangan/")->with('success', "All Keuangan data for Kolam Barat has been successfully deleted. ($deletedCount records removed)");
            } else {
                return redirect("dashboard/Keuangan/")->with('info', 'No Keuangan data found for Kolam Barat to delete.');
            }
        } catch (\Exception $e) {
            // If an error occurs, redirect back with an error message
            return redirect("dashboard/Keuangan/")->with('error', 'An error occurred while deleting Keuangan data: ' . $e->getMessage());
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
        $jumlah_ikan_timur = Keuangan::where('lokasi', 'like', '%kolam timur%')
            ->sum('jumlah_ikan');

        // tampilkan jumlah ikan kolam barat
        $jumlah_ikan_barat = Keuangan::where('lokasi', 'like', '%kolam barat%')
            ->sum('jumlah_ikan');

        // Membuat array untuk menyimpan data
        $view_data = [
            'jumlah_ikan_timur' => $jumlah_ikan_timur,
            'jumlah_ikan_barat' => $jumlah_ikan_barat,
            // 'chartData' => $chartData,
        ];

        return view('dashboard.Keuangan.jumlah_ikan.jumlahikan', $view_data);
    }

    // Tampilkan data setiap musim panen
    public function musim_panen($season)
    {
        $tasks = Keuangan::where('musim_panen', $season)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalBiaya = Keuangan::where('musim_panen', $season)->sum('biaya');
        $jumlahIkan = Keuangan::where('musim_panen', $season)->sum('jumlah_ikan');

        return view('dashboard.Keuangan.musim_panen', compact('tasks', 'totalBiaya', 'jumlahIkan', 'season'));
    }

    // fungsi menampilkan chart
    public function chartData(Request $request)
    {
        $query = Keuangan::where('active', true);

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        // clone berfungsi untuk mengcopy hasil dari $query tanpa merubah hasil sebelumnya
        return response()->json([
            'pemasukan' => (clone $query)->sum('pemasukan'),
            'pengeluaran' => (clone $query)->sum('pengeluaran'),
        ]);
    }

    // fungsi export
    public function exportExcel(Request $request)
    {
        $start = $request->start_date;
        $end   = $request->end_date;

        return Excel::download(new KeuanganExport($start, $end), 'laporan-keuangan.xlsx');
    }
}
