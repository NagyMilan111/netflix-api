<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    public function definition()
    {
        static $roles = ['Admin', 'User'];
        static $index = 0;

        if ($index >= count($roles)) {
            $index = 0; // Reset index if it exceeds available roles
        }

        return [
            'role_name' => $roles[$index++],
        ];
    }
}

