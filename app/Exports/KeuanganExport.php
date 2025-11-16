<?php

namespace App\Exports;

use App\Models\Keuangan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KeuanganExport implements FromCollection, WithHeadings
{
    protected $start;
    protected $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function collection()
    {
        $query = Keuangan::where('active', true);

        if ($this->start && $this->end) {
            $query->whereBetween('created_at', [$this->start, $this->end]);
        }

        $totalKeseluruhan = $query->clone()->sum(Keuangan::raw('pemasukan - pengeluaran'));

        return $query->select('created_at', 'pemasukan', 'pengeluaran')->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Pemasukan',
            'Pengeluaran',
        ];
    }
}
