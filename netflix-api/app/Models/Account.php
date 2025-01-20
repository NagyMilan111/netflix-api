<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $primaryKey = 'account_id';

    protected $fillable = [
        'email',
        'hashed_password',
        'is_blocked',
        'account_scheme',
        'subscription_id',
    ];

    /**
     * Many-to-Many relationship with Role
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'account_roles', 'account_id', 'role_id');
    }

    /**
     * Relationship with Subscription
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id', 'subscription_id');
    }
}
