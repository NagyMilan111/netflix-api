<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountedUser extends Model
{
    use HasFactory;

    protected $table = 'discounted_users';
    protected $fillable = ['account_id', 'invited_account_id'];

    // Relationships
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function invitedAccount()
    {
        return $this->belongsTo(Account::class, 'invited_account_id');
    }
}