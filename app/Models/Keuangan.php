<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keuangan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'keuangan';  // menggunakan tabel keuangan

    // fungsi untuk mengisi data yang boleh masuk ke database
    public $fillable = [
        'pemasukan',
        'pengeluaran',
        'sisa',
        'created_at',
        'updated_at',
        'deleted_at',
        'active',
    ];
}
