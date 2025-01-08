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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id('account_id');
            $table->string('email')->unique();
            $table->string('hashed_password');
            $table->boolean('is_blocked')->default(false);
            $table->string('account_scheme')->default('default');
            $table->unsignedBigInteger('subscription_id')->nullable(); // Foreign key to subscriptions
            $table->timestamps();
        
            $table->foreign('subscription_id')
                ->references('subscription_id') // Match primary key in subscriptions
                ->on('subscriptions')
                ->onDelete('set null'); // Set null if the subscription is deleted
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
