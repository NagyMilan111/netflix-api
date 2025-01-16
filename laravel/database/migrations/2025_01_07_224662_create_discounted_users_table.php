<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discounted_users', function (Blueprint $table) {
            // Foreign key columns
            $table->unsignedBigInteger('account_id'); // References accounts table
            $table->unsignedBigInteger('invited_account_id'); // References accounts table
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('account_id')
                  ->references('account_id') // References the primary key in accounts
                  ->on('accounts')
                  ->onDelete('cascade');

            $table->foreign('invited_account_id')
                  ->references('account_id') // References the primary key in accounts
                  ->on('accounts')
                  ->onDelete('cascade');

            // Composite primary key
            $table->primary(['account_id', 'invited_account_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discounted_users');
    }
};