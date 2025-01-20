<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtitle extends Model
{
    use HasFactory;

    protected $primaryKey = 'subtitle_id';
    protected $fillable = ['media_id', 'lang_id', 'subtitle_location'];

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang_id');
    }

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }
}
