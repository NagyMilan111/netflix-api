<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    protected $model = Account::class;

    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'hashed_password' => bcrypt('password'), // Default password for testing
        ];
    }
}
