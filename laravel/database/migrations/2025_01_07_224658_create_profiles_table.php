<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id('profile_id'); // Custom primary key
            $table->unsignedBigInteger('account_id'); // Foreign key (must match accounts.account_id)
            $table->string('profile_name');
            $table->string('profile_image');
            $table->integer('profile_age');
            $table->integer('profile_fang');
            $table->boolean('profile_movies_preferred')->default(false);
            $table->timestamps();
        
            // Foreign key constraint
            $table->foreign('account_id')
                  ->references('account_id') // References the primary key in accounts
                  ->on('accounts')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
