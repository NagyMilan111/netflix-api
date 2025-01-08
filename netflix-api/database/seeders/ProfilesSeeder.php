<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfilesSeeder extends Seeder
{
    public function run()
    {
        Account::all()->each(function ($account) {
            Profile::factory(2)->create([
                'account_id' => $account->account_id,
            ]);
        });

        $this->command->info('Profiles seeded successfully.');
    }
}
