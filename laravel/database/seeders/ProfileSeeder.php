<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProfileSeeder extends Seeder
{
    public function run()
    {
        // Instantiate Faker
        $faker = Faker::create();

        // Get all account records
        $accounts = Account::all();

        // Ensure there are account records to associate with profiles
        if ($accounts->isEmpty()) {
            $this->command->warn('No account records found. Please run the AccountSeeder first.');
            return;
        }

        // Create profiles for each account
        foreach ($accounts as $account) {
            $numProfiles = rand(1, 3); // Each account has 1–3 profiles
            for ($i = 0; $i < $numProfiles; $i++) {
                $account = Account::inRandomOrder()->first();
                Profile::create([
                    'account_id' => $account->account_id, // Use the correct primary key for accounts
                    'profile_name' => $faker->name, // Use Faker to generate a name
                    'profile_image' => 'https://via.placeholder.com/640x480.png/0000cc?text=profile',
                    'profile_age' => rand(10, 80),
                    'profile_fang' => rand(0, 100),
                    'profile_movies_preferred' => (bool) rand(0, 1),
                ]);
            }
        }

        $this->command->info('ProfileSeeder completed successfully.');
    }
}