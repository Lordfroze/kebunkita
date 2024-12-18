<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perikanan extends Model
{
    //
    Use HasFactory;
    protected $table = 'perikanan';  // menggunakan tabel perikanan
    public function scopeActive($query)
    {
        return $query->where('active', 'true');
    }
}
