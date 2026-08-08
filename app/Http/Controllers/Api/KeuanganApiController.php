<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use Illuminate\Http\Request;

class KeuanganApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Keuangan::where('active', true);

        $start = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $end = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        $query->whereBetween('created_at', [$start, $end]);

        $totalPemasukan = (clone $query)->sum('pemasukan');
        $totalPengeluaran = (clone $query)->sum('pengeluaran');
        $totalKeseluruhan = (clone $query)->sum(Keuangan::raw('pemasukan - pengeluaran'));

        $tasks = (clone $query)
            ->orderBy('created_at', 'desc')
            ->select('id', 'pemasukan', 'pengeluaran', 'created_at')
            ->get();

        return response()->json([
            'data' => $tasks,
            'total_pemasukan' => (float) $totalPemasukan,
            'total_pengeluaran' => (float) $totalPengeluaran,
            'total_keseluruhan' => (float) $totalKeseluruhan,
            'start_date' => $start,
            'end_date' => $end,
        ]);
    }

    public function show(string $id)
    {
        $task = Keuangan::where('active', true)
            ->select('id', 'pemasukan', 'pengeluaran', 'created_at')
            ->find($id);

        if (! $task) {
            return response()->json([
                'message' => 'Data keuangan tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'data' => $task,
        ]);
    }

    public function chart(Request $request)
    {
        $query = Keuangan::where('active', true);

        $tahunTersedia = (clone $query)
            ->selectRaw('YEAR(created_at) as tahun')
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();

        if (empty($tahunTersedia)) {
            $tahunTersedia = [(int) date('Y')];
        }

        $tahun = $request->input('tahun', $tahunTersedia[0]);

        $bulanan = (clone $query)
            ->selectRaw('MONTH(created_at) as bulan')
            ->selectRaw('COALESCE(SUM(pemasukan), 0) as pemasukan')
            ->selectRaw('COALESCE(SUM(pengeluaran), 0) as pengeluaran')
            ->whereYear('created_at', $tahun)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $pemasukan = array_fill(0, 12, 0);
        $pengeluaran = array_fill(0, 12, 0);

        foreach ($bulanan as $row) {
            $pemasukan[$row->bulan - 1] = (int) $row->pemasukan;
            $pengeluaran[$row->bulan - 1] = (int) $row->pengeluaran;
        }

        return response()->json([
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'tahun' => (int) $tahun,
            'tahunTersedia' => $tahunTersedia,
        ]);
    }
}
