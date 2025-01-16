<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Subscription;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    public function run()
    {
        // Ensure there is at least one subscription in the database
        $subscription = Subscription::first();

        if (!$subscription) {
            // Create a default subscription if none exists
            $subscription = Subscription::create([
                'subscription_name' => 'Basic',
                'subscription_price' => 7.99,
            ]);
        }

        // Create one admin user with a valid subscription_id
        Account::create([
            'email' => 'admin@example.com',
            'hashed_password' => Hash::make('admin123'),
            'blocked' => false,
            'discount_active' => false,
            'billed_from' => now(),
            'subscription_id' => $subscription->subscription_id, // Provide a valid subscription_id
        ]);

        // Create randomized users (3–5 entries)
        $numUsers = rand(3, 5);

        for ($i = 0; $i < $numUsers - 1; $i++) {
            $subscriptions = Subscription::all();
            Account::create([
                'email' => fake()->unique()->safeEmail,
                'hashed_password' => Hash::make('password'),
                'blocked' => (bool) rand(0, 1),
                'discount_active' => (bool) rand(0, 1),
                'billed_from' => now()->subDays(rand(1, 365)),
                'subscription_id' => $subscriptions->random()->subscription_id, // Random subscription
            ]);
        }
    }
}