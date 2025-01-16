<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profile_genre', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id'); // Foreign key to profiles
            $table->unsignedBigInteger('genre_id');   // Foreign key to genres
            $table->timestamps();
        
            // Foreign key constraints
            $table->foreign('profile_id')
                  ->references('profile_id') // Reference the custom primary key in profiles
                  ->on('profiles')
                  ->onDelete('cascade');
        
            $table->foreign('genre_id')
                  ->references('genre_id')
                  ->on('genres')
                  ->onDelete('cascade');
        
            // Unique constraint to prevent duplicate entries
            $table->unique(['profile_id', 'genre_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_genre');
    }
};