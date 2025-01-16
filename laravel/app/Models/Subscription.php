<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $primaryKey = 'subscription_id'; // Custom primary key
    protected $fillable = [
        'subscription_name',
        'subscription_price',
    ];

    // Relationships
    public function accounts()
    {
        return $this->hasMany(Account::class, 'subscription_id');
    }
}