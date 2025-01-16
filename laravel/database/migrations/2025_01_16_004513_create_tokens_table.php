<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->id('token_id'); // Primary key
            $table->unsignedBigInteger('account_id'); // Foreign key to accounts table
            $table->string('token')->unique(); // Token string (unique)
            $table->timestamps(); // created_at and updated_at

            // Foreign key constraint
            $table->foreign('account_id')
                  ->references('account_id')
                  ->on('accounts') // Ensure this matches the table name in the database
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tokens');
    }
};