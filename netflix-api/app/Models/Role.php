<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $primaryKey = 'role_id';

    protected $fillable = ['role_name'];

    public function accounts()
    {
        return $this->belongsToMany(Account::class, 'account_roles', 'role_id', 'account_id');
    }
}
