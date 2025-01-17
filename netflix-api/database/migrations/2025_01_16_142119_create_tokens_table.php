<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('tokens')) {
            Schema::create('tokens', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('account_id'); // Foreign key to Account table
                $table->string('token');
                $table->timestamps();

                // Foreign key constraint
                $table->foreign('account_id')
                      ->references('account_id') // References the primary key in Account
                      ->on('Account') // References the Account table
                      ->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tokens');
    }
};