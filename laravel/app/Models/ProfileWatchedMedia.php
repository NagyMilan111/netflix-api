<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileWatchedMedia extends Model
{
    use HasFactory;

    protected $table = 'profile_watched_media';
    protected $fillable = [
        'profile_id',
        'media_id',
        'subtitle_id',
        'pause_spot',
        'times_watched',
        'last_watch_date',
    ];
}