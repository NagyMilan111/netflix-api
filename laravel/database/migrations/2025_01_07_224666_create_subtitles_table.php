<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subtitles', function (Blueprint $table) {
            $table->id('subtitle_id'); // Primary key is `subtitle_id`
            $table->unsignedBigInteger('subtitle_lang'); // Foreign key to languages table
            $table->unsignedBigInteger('media_id'); // Foreign key to media
            $table->string('subtitle_position'); // Example column
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('media_id')
                  ->references('media_id') // References the primary key in media
                  ->on('media')
                  ->onDelete('cascade');

            $table->foreign('subtitle_lang')
                  ->references('lang_id') // References the primary key in languages
                  ->on('languages')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subtitles');
    }
};