<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Subscription;
use Illuminate\Database\Seeder;

class DiscountedUsersSeeder extends Seeder
{
    public function run()
    {
        $subscriptions = Subscription::all();

        if ($subscriptions->isEmpty()) {
            $this->command->error('No subscriptions found. Please seed the subscriptions table first.');
            return;
        }

        $discountedAccounts = Account::inRandomOrder()->take(3)->get();

        foreach ($discountedAccounts as $account) {
            \DB::table('discounted_users')->insert([
                'account_id' => $account->account_id,
                'subscription_id' => $subscriptions->random()->subscription_id, // Reference subscription_id
                'discount_percentage' => rand(10, 50), // Random discount between 10% and 50%
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Discounted users seeded successfully.');
    }
}
