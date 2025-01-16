<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $primaryKey = 'genre_id';
    protected $fillable = ['genre_name'];

    // Relationships
    public function profiles()
    {
        return $this->belongsToMany(Profile::class, 'profile_genre', 'genre_id', 'profile_id');
    }

    public function series()
    {
        return $this->hasMany(Series::class, 'genre_id');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'genre_id');
    }
}