<?php

namespace App\Exports;

use App\Models\Perikanan;
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
        $query = Perikanan::select('created_at', 'kegiatan', 'lokasi', 'biaya', 'musim_panen', 'jumlah_ikan');

        if (!empty($this->filters['lokasi'])) {
            $query->where('lokasi', $this->filters['lokasi']);
        }

        if (!empty($this->filters['lokasi_like'])) {
            $query->where('lokasi', 'like', '%' . $this->filters['lokasi_like'] . '%');
        }

        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereBetween('created_at', [$this->filters['start_date'], $this->filters['end_date']]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return ['created_at', 'kegiatan', 'lokasi', 'biaya', 'musim_panen', 'jumlah_ikan'];
    }
}
