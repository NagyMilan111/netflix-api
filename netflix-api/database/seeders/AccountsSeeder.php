<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Role;
use App\Models\Subscription;
use Illuminate\Database\Seeder;

class AccountsSeeder extends Seeder
{
    public function run()
    {
        // Fetch roles
        $adminRole = Role::where('role_name', 'Admin')->first();
        $userRole = Role::where('role_name', 'User')->first();
        $subscriptions = Subscription::all();

        if (!$adminRole || !$userRole || $subscriptions->isEmpty()) {
            $this->command->error('Roles or subscriptions are missing. Please seed Roles and Subscriptions first.');
            return;
        }

        // Create an admin account
        $adminAccount = Account::factory()->create([
            'email' => 'admin@example.com',
            'hashed_password' => bcrypt('admin123'),
            'subscription_id' => $subscriptions->random()->subscription_id, // Assign a random subscription
        ]);

        $adminAccount->roles()->attach($adminRole->role_id);

        $this->command->info('Admin account created and linked to Admin role.');

        // Create user accounts
        Account::factory(10)->create()->each(function ($account) use ($userRole, $subscriptions) {
            $account->subscription_id = $subscriptions->random()->subscription_id;
            $account->save();

            $account->roles()->attach($userRole->role_id);
            $this->command->info("User account created with ID: {$account->account_id} and linked to User role.");
        });

        $this->command->info('Accounts and roles seeded successfully.');
    }
}
