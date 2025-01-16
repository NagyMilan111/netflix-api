<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;

    protected $primaryKey = 'series_id';
    protected $fillable = ['title', 'genre_id', 'number_of_seasons', 'times_watched'];

    // Relationships
    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'series_id');
    }
}
