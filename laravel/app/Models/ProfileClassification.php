<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileClassification extends Model
{
    use HasFactory;

    protected $table = 'profile_classification';
    protected $fillable = ['profile_id', 'classification_id'];
}