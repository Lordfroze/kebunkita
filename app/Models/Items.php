<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'items';  // menggunakan tabel gudang

    // fungsi untuk mengisi data yang boleh masuk ke database
    public $fillable = [
        'kode_barang',
        'nama_barang',
        'stock',
        'created_at',
        'updated_at',
        'harga_modal',
        'harga_beli',
        'harga_jual',
        'active',
    ];

    // public function scopeActive($query)
    // {
    //     return $query->where('active', 'true');
    // }
}
