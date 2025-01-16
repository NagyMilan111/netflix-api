<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table = 'tokens'; // Ensure this matches your database table name
    public $timestamps = true;

    protected $fillable = [
        'account_id',
        'token',
    ];
}
