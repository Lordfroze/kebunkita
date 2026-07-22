<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keuangan extends Model
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

    protected $table = 'keuangan';  // menggunakan tabel keuangan

    public $fillable = [
        'user_id',
        'pemasukan',
        'pengeluaran',
        'sisa',
        'created_at',
        'updated_at',
        'deleted_at',
        'active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
