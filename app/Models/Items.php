<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected static function booted(): void
    {
        static::addGlobalScope(new \App\Models\Scopes\UserDataScope);

        static::creating(function ($model) {
            if (auth()->check() && !$model->user_id) {
                $model->user_id = auth()->id();
            }
        });
    }

    protected $table = 'items';  // menggunakan tabel gudang

    public $fillable = [
        'user_id',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function scopeActive($query)
    // {
    //     return $query->where('active', 'true');
    // }
}
