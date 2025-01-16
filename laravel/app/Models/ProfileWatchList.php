<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileWatchList extends Model
{
    use HasFactory;

    protected $primaryKey = 'list_id';
    protected $fillable = ['profile_id', 'media_id', 'subtitle_id', 'pause_spot', 'times_watched', 'last_watch_date'];

    // Relationships
    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id', 'profile_id');
    }

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function subtitle()
    {
        return $this->belongsTo(Subtitle::class, 'subtitle_id');
    }
}