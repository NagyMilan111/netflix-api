<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileViewingClassification extends Model
{
    use HasFactory;

    protected $table = 'profile_viewing_classification'; // Explicitly define the table name
    protected $primaryKey = ['profile_id', 'classification_id']; // Composite primary key
    public $incrementing = false; // Disable auto-incrementing for composite keys

    protected $fillable = [
        'profile_id',
        'classification_id',
    ];
}