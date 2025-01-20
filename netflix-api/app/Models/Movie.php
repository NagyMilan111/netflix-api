<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $primaryKey = 'media_id';
    protected $fillable = ['title', 'genre_id', 'has_4k_version', 'has_3d_version'];

    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }

    public function subtitles()
    {
        return $this->hasMany(Subtitle::class, 'media_id');
    }
}
