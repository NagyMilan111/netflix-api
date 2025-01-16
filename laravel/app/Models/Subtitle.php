<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtitle extends Model
{
    use HasFactory;

    protected $primaryKey = 'subtitle_id';
    protected $fillable = ['subtitle_lang', 'media_id', 'subtitle_position'];

    // Relationships
    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function watchLists()
    {
        return $this->hasMany(ProfileWatchList::class, 'subtitle_id');
    }

    
}