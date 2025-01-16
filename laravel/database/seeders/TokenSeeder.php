<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Token;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TokenSeeder extends Seeder
{
    public function run()
    {
        // Fetch the admin account
        $adminAccount = Account::where('email', 'admin@example.com')->first();

        if ($adminAccount) {
            // Generate a token for the admin account
            Token::create([
                'account_id' => $adminAccount->account_id,
                'token' => Str::random(40), // Generate a random token
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Fetch all other accounts (excluding the admin)
        $otherAccounts = Account::where('email', '!=', 'admin@example.com')->get();

        // Generate tokens for other accounts
        foreach ($otherAccounts as $account) {
            Token::create([
                'account_id' => $account->account_id,
                'token' => Str::random(40), // Generate a random token
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}