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

    // menambah komentar
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // menambahkan total komentar
    public function total_comments(){
        return $this->comments()->count();
    }
}
