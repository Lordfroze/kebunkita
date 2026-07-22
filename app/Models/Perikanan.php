<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perikanan extends Model
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

    protected $table = 'perikanan';  // menggunakan tabel perikanan

    public $fillable = [
        'user_id',
        'kegiatan',
        'lokasi',
        'biaya',
        'created_at',
        'updated_at',
        'musim_panen',
        'jumlah_ikan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', 'true');
    }

    // menambah komentar mengambil data dari model Comment
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // menambahkan total komentar
    public function total_comments()
    {
        return $this->comments()->count();
    }
}
