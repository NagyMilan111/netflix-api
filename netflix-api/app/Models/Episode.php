<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    protected $primaryKey = 'episode_id';
    protected $fillable = ['series_id', 'title'];

    public function series()
    {
        return $this->belongsTo(Series::class, 'series_id');
    }
}
