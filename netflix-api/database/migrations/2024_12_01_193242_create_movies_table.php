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
        Schema::create('movies', function (Blueprint $table) {
            $table->id('movie_id');
            $table->string('title');
            $table->unsignedBigInteger('genre_id'); // Ensure it's unsigned
            $table->foreign('genre_id')
                ->references('genre_id')
                ->on('genres')
                ->onDelete('cascade'); // Optional: Cascade delete if the genre is deleted
            $table->boolean('has_uhd_version')->default(false);
            $table->boolean('has_hd_version')->default(false);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
