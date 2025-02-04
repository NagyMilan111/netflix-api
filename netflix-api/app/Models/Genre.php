<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $primaryKey = 'genre_id';
    protected $fillable = ['genre_name'];

    public function profiles()
    {
        return $this->belongsToMany(Profile::class, 'profile_genres', 'genre_id', 'profile_id');
    }

    public function movies()
    {
        return $this->hasMany(Movie::class, 'genre_id');
    }

    public function series()
    {
        return $this->hasMany(Series::class, 'genre_id');
    }
}
