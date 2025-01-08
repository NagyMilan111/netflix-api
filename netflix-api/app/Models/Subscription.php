<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $primaryKey = 'subscription_id';
    protected $fillable = ['subscription_name', 'subscription_price'];

    public function discountedAccounts()
    {
        return $this->belongsToMany(Account::class, 'discounted_users', 'subscription_id', 'account_id')->withPivot('discount_percentage');
    }
}
