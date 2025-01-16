<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\DiscountedUser;
use Illuminate\Database\Seeder;

class DiscountedUserSeeder extends Seeder
{
    public function run()
{
    $accounts = Account::all();

    foreach ($accounts as $account) {
        $invitedAccount = Account::where('account_id', '!=', $account->account_id)->inRandomOrder()->first();

        // Check if the combination already exists
        $exists = DiscountedUser::where('account_id', $account->account_id)
            ->where('invited_account_id', $invitedAccount->account_id)
            ->exists();

        if (!$exists) {
            DiscountedUser::create([
                'account_id' => $account->account_id,
                'invited_account_id' => $invitedAccount->account_id,
            ]);
        }
    }
}
}