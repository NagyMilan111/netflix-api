<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    // Relationship to views
    public function views()
    {
        return $this->hasMany(View::class);
    }
    protected $primaryKey = 'media_id';
    protected $fillable = ['title', 'series_id', 'season', 'genre_id', 'duration'];

    // Relationships
    public function series()
    {
        return $this->belongsTo(Series::class, 'series_id');
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }

    public function subtitles()
    {
        return $this->hasMany(Subtitle::class, 'media_id');
    }

    public function mediaQualities()
    {
        return $this->hasMany(MediaQuality::class, 'media_id');
    }

    public function watchLists()
    {
        return $this->hasMany(ProfileWatchList::class, 'media_id');
    }
}