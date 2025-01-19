<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = DB::table('perikanan')->select('created_at', 'kegiatan', 'lokasi', 'biaya', 'musim_panen'); // Tambahkan kolom lokasi dan tanggal

        // Filter berdasarkan lokasi tertentu
        if (!empty($this->filters['lokasi'])) {
            $query->where('lokasi', $this->filters['lokasi']);
        }

        // Filter lokasi yang mirip (opsional)
        if (!empty($this->filters['lokasi_like'])) {
            $query->where('lokasi', 'like', '%' . $this->filters['lokasi_like'] . '%');
        }

         // Filter berdasarkan rentang tanggal
         if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereBetween('created_at', [$this->filters['start_date'], $this->filters['end_date']]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return ['created_at', 'kegiatan', 'lokasi', 'biaya','musim_panen' ]; // Pastikan header sesuai
    }
}
