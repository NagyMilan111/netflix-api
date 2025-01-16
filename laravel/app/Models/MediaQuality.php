<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaQuality extends Model
{
    use HasFactory;

    protected $fillable = ['media_id', 'has_uhd_version', 'has_hd_version', 'has_sd_version'];

    // Relationships
    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }
}