<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perikanan extends Model
{
    //
    Use HasFactory;
    use SoftDeletes;
    
    protected $table = 'perikanan';  // menggunakan tabel perikanan
    public function scopeActive($query)
    {
        return $query->where('active', 'true');
    }
}
