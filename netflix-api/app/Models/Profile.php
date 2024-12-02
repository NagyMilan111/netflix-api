<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $primaryKey = 'profile_id';
    protected $fillable = ['account_id', 'profile_name', 'profile_language', 'profile_is_kids', 'role_id'];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'profile_genres', 'profile_id', 'genre_id');
    }

    public function watchedMedia()
    {
        return $this->belongsToMany(Media::class, 'profiles_watched_media', 'profile_id', 'media_id')
            ->withPivot('percentage_watched', 'last_watched_date');
    }

    public function watchList()
    {
        return $this->belongsToMany(Media::class, 'profiles_watch_list', 'profile_id', 'media_id');
    }

    public function viewingClassifications()
    {
        return $this->belongsToMany(ViewingClassification::class, 'profile_viewing_classification', 'profile_id', 'classification_id');
    }
}
