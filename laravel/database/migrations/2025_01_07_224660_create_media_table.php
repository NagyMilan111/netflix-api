<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id('media_id'); // This creates an unsignedBigInteger primary key
            $table->string('title');
            $table->unsignedBigInteger('series_id')->nullable();
            $table->integer('season')->nullable();
            $table->unsignedBigInteger('genre_id')->nullable(); // Foreign key
            $table->time('duration')->default('00:00:00');
            $table->timestamps();
        
            // Foreign key constraints
            $table->foreign('series_id')
                  ->references('series_id')
                  ->on('series')
                  ->onDelete('cascade');
        
            $table->foreign('genre_id')
                  ->references('genre_id')
                  ->on('genres')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};