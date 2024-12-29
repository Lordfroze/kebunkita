<?php

namespace App\Exports;

use App\Models\Perikanan;// Replace with your actual model
use Maatwebsite\Excel\Concerns\FromCollection;

class DataExport implements FromCollection
{
    public function collection()
    {
        return Perikanan::all(); // Replace with your data retrieval logic
    }
}
