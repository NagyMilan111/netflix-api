<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewingClassification extends Model
{
    use HasFactory;

    protected $primaryKey = 'classification_id';
    protected $fillable = ['classification_name'];

    public function profiles()
    {
        return $this->belongsToMany(Profile::class, 'profile_viewing_classification', 'classification_id', 'profile_id');
    }
}
