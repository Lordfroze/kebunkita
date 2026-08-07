<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Keuangan;
use App\Models\Perikanan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Halaman home
    public function index()
    {
        // otentikasi jika user belum login
        if (! Auth::check()) {
            return redirect('login');
        }

        $bulanIndonesia = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        $keuangan = Keuangan::where('active', true)->get();
        $totalPemasukan = (float) $keuangan->sum('pemasukan');
        $totalPengeluaran = (float) $keuangan->sum('pengeluaran');

        $bulanIni = now()->format('Y-m');
        $pemasukanBulanIni = (float) $keuangan
            ->filter(fn ($k) => optional($k->created_at)->format('Y-m') === $bulanIni)
            ->sum('pemasukan');
        $pengeluaranBulanIni = (float) $keuangan
            ->filter(fn ($k) => optional($k->created_at)->format('Y-m') === $bulanIni)
            ->sum('pengeluaran');

        // Chart arus kas 7 bulan terakhir
        $chart = collect(range(6, 0))->map(function ($offset) use ($keuangan, $bulanIndonesia) {
            $m = now()->subMonths($offset);

            return [
                'label' => $bulanIndonesia[(int) $m->format('n') - 1],
                'pemasukan' => (float) $keuangan
                    ->filter(fn ($k) => optional($k->created_at)->format('Y-m') === $m->format('Y-m'))
                    ->sum('pemasukan'),
                'pengeluaran' => (float) $keuangan
                    ->filter(fn ($k) => optional($k->created_at)->format('Y-m') === $m->format('Y-m'))
                    ->sum('pengeluaran'),
            ];
        });

        $topItems = Items::orderByRaw('CAST(stock AS UNSIGNED) DESC')
            ->take(8)
            ->get(['nama_barang', 'stock']);

        $recent = collect()
            ->concat(Keuangan::where('active', true)->latest()->take(4)->get()
                ->map(fn ($k) => [
                    'judul' => $k->pemasukan > 0 ? 'Pemasukan keuangan' : 'Pengeluaran keuangan',
                    'sub' => 'Rp '.number_format((float) ($k->pemasukan > 0 ? $k->pemasukan : $k->pengeluaran), 0, ',', '.'),
                    'waktu' => optional($k->created_at)->diffForHumans(),
                    'tipe' => $k->pemasukan > 0 ? 'pemasukan' : 'pengeluaran',
                ]))
            ->concat(User::latest()->take(2)->get()->map(fn ($u) => [
                'judul' => 'Pengguna baru: '.$u->name,
                'sub' => $u->role === 'admin' ? 'Administrator' : 'Pengguna',
                'waktu' => optional($u->created_at)->diffForHumans(),
                'tipe' => 'user',
            ]))
            ->concat(Items::latest()->take(2)->get()->map(fn ($i) => [
                'judul' => 'Barang baru: '.$i->nama_barang,
                'sub' => 'Stok: '.$i->stock,
                'waktu' => optional($i->created_at)->diffForHumans(),
                'tipe' => 'stok',
            ]))
            ->values()
            ->take(7);

        $stats = [
            'keuangan' => $keuangan->count(),
            'items' => Items::count(),
            'users' => User::count(),
            'pemasukanBulanIni' => $pemasukanBulanIni,
            'pengeluaranBulanIni' => $pengeluaranBulanIni,
            'pemasukanBulanIniText' => 'Rp '.number_format($pemasukanBulanIni, 0, ',', '.'),
            'pengeluaranBulanIniText' => 'Rp '.number_format($pengeluaranBulanIni, 0, ',', '.'),
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
        ];

        return view('dashboard/index', [
            'stats' => $stats,
            'chart' => $chart,
            'topItems' => $topItems,
            'recent' => $recent,
        ]);
    }

    // Halaman setting Perikanan
    public function settingkolam()
    {
        // otentikasi jika user belum login
        if (! Auth::check()) {
            return redirect('login');
        }

        return view('dashboard/perikanan/settingkolam');
    }

    //Halaman setting kebun
    public function settingkebun()
    {
        // otentikasi jika user belum login
        if (! Auth::check()) {
            return redirect('login');
        }

        return view('dashboard/perkebunan/settingkebun');
    }

    //Halaman setting perdagangan
    public function settingbarang()
    {
        // otentikasi jika user belum login
        if (! Auth::check()) {
            return redirect('login');
        }

        return view('dashboard/perdagangan/settingbarang');
    }

    // Halaman Download
    public function download()
    {
        // otentikasi jika user belum login
        if (! Auth::check()) {
            return redirect('login');
        }

        return view('dashboard/download/index');
    }
}
