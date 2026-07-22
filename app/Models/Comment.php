<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'perikanan_id',
        'comment',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new \App\Models\Scopes\UserDataScope);

        static::creating(function ($model) {
            if (auth()->check() && !$model->user_id) {
                $model->user_id = auth()->id();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function perikanan()
    {
        return $this->belongsTo(Perikanan::class);
    }
}
