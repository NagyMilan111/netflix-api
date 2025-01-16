<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('accounts')) {
            Schema::create('accounts', function (Blueprint $table) {
                $table->id('account_id'); // Primary key (unsignedBigInteger)
                $table->string('email')->unique();
                $table->string('hashed_password');
                $table->boolean('blocked')->default(false);
                $table->boolean('discount_active')->default(false);
                $table->date('billed_from')->nullable();
                $table->unsignedBigInteger('subscription_id'); // Foreign key (must match subscriptions.subscription_id)
                $table->timestamps();
            
                // Foreign key constraint
                $table->foreign('subscription_id')
                      ->references('subscription_id') // References the primary key in subscriptions
                      ->on('subscriptions')
                      ->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};