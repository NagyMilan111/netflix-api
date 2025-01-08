<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $table = 'medias'; // Explicitly specify the table name if necessary

    protected $primaryKey = 'media_id';

    protected $fillable = [
        'title',
        'duration',
    ];
}
