<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    public function run()
    {
        // Create the three subscription types
        Subscription::create(['subscription_name' => 'Basic', 'subscription_price' => 7.99]);
        Subscription::create(['subscription_name' => 'Standard', 'subscription_price' => 10.99]);
        Subscription::create(['subscription_name' => 'Premium', 'subscription_price' => 13.99]);

        $this->command->info('Subscriptions seeded successfully.');
    }
}