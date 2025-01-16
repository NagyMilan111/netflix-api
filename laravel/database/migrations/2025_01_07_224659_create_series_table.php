<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id('series_id');
            $table->string('title');
            $table->unsignedBigInteger('genre_id'); // Foreign key
            $table->integer('number_of_seasons')->default(1);
            $table->integer('times_watched')->default(0);
            $table->timestamps();
        
            // Foreign key constraint
            $table->foreign('genre_id')
                  ->references('genre_id')
                  ->on('genres')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};