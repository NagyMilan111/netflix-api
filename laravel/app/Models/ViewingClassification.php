<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewingClassification extends Model
{
    use HasFactory;

    protected $primaryKey = 'classification_id'; // Custom primary key
    protected $fillable = ['classification'];

    // Relationship to profiles
    public function profiles()
    {
        return $this->belongsToMany(
            Profile::class, // Related model
            'profile_viewing_classification', // Pivot table
            'classification_id', // Foreign key on the viewing_classifications table
            'profile_id' // Foreign key on the profiles table
        );
    }
}