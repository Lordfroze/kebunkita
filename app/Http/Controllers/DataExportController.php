<?php

namespace App\Http\Controllers;

use App\Exports\DataExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DataExportController extends Controller
{
    public function exportExcel(Request $request)
    {
        // Ambil filter dari request, termasuk lokasi
        $filters = $request->only(['lokasi', 'lokasi_like', 'start_date', 'end_date']);

        // Unduh file Excel dengan filter
        $fileName = 'data_filtered_by_lokasi.xlsx';
        return Excel::download(new DataExport($filters), $fileName);
    }
}
