<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;

    protected $primaryKey = 'id'; // Ensure this matches the database schema
    public $incrementing = true; // Ensure the primary key auto-increments
    protected $keyType = 'int'; // Set the primary key type

    protected $fillable = [
        'title',
        'genre_id',
        'number_of_seasons',
    ];
}
