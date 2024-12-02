<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('discounted_users', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('account_id'); // Foreign key to accounts table
            $table->unsignedBigInteger('subscription_id')->nullable(); // Foreign key to subscriptions table
            $table->integer('discount_percentage');
            $table->timestamps();
        
            // Foreign key constraints
            $table->foreign('account_id')
                ->references('account_id')
                ->on('accounts')
                ->onDelete('cascade');
            
            $table->foreign('subscription_id')
                ->references('subscription_id') // Match the primary key in subscriptions
                ->on('subscriptions')
                ->onDelete('cascade');
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounted_users');
    }
};
