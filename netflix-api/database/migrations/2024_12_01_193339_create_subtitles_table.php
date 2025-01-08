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
        Schema::create('subtitles', function (Blueprint $table) {
            $table->id('subtitle_id'); // Primary key
            $table->unsignedBigInteger('media_id'); // Foreign key to medias table
            $table->foreign('media_id')
                ->references('media_id')
                ->on('medias')
                ->onDelete('cascade');
            $table->unsignedBigInteger('lang_id'); // Foreign key to languages table
            $table->foreign('lang_id')
                ->references('lang_id')
                ->on('languages')
                ->onDelete('cascade');
            $table->string('subtitle_location'); // Location of the subtitle file
            $table->timestamps();
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subtitles');
    }
};
