<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RehashPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rehash:passwords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rehash plaintext or improperly hashed passwords in the Account table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $accounts = DB::table('Account')->get();

        foreach ($accounts as $account) {
            if (!Hash::needsRehash($account->hashed_password)) {
                continue; // Skip if the password is already properly hashed
            }

            DB::table('Account')
                ->where('account_id', $account->account_id)
                ->update([
                    'hashed_password' => Hash::make('examplePasswordFor' . $account->account_id), // Replace with actual password logic
                ]);
        }

        $this->info('Passwords rehashed successfully.');
    }
}
