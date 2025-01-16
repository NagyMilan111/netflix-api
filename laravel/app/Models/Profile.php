<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    // Relationship to views
    public function views()
    {
        return $this->hasMany(View::class, 'profile_id', 'profile_id');
    }

    protected $primaryKey = 'profile_id'; // Custom primary key
    protected $fillable = ['account_id', 'profile_name', 'profile_image', 'profile_age',
     'profile_fang', 'profile_movies_preferred'];

    // Relationships
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function watchLists()
    {
        return $this->hasMany(ProfileWatchList::class, 'profile_id', 'profile_id');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'profile_genre', 'profile_id', 'genre_id');
    }

    public function viewingClassifications()
    {
        return $this->belongsToMany(
            ViewingClassification::class, // Related model
            'profile_viewing_classification', // Pivot table
            'profile_id', // Foreign key on the profiles table
            'classification_id' // Foreign key on the viewing_classifications table
        );
    }

    public function watchedMedia()
    {
        return $this->belongsToMany(Media::class, 'profile_watched_media', 'profile_id', 'media_id')
                    ->withPivot('pause_spot', 'times_watched', 'last_watch_date');
    }
}