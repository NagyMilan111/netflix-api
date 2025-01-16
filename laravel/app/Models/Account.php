<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $primaryKey = 'account_id'; // Custom primary key
    protected $fillable = [
        'email',
        'hashed_password',
        'blocked',
        'discount_active',
        'billed_from',
        'subscription_id',
    ];

    // Relationships
    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }

    public function profiles()
    {
        return $this->hasMany(Profile::class, 'account_id');
    }
    
     public function discountedUsers()
    {
        return $this->hasMany(DiscountedUser::class, 'account_id');
    }

}
