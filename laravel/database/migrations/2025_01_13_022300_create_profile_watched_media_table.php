<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profile_watched_media', function (Blueprint $table) {
            $table->unsignedBigInteger('profile_id');
            $table->unsignedBigInteger('media_id');
            $table->unsignedBigInteger('subtitle_id')->nullable(); // Foreign key to subtitles
            $table->time('pause_spot')->default('00:00:00');
            $table->integer('times_watched')->default(0);
            $table->date('last_watch_date')->nullable();
            $table->timestamps();
        
            // Foreign key constraints
            $table->foreign('profile_id')
                  ->references('profile_id')
                  ->on('profiles')
                  ->onDelete('cascade');
        
            $table->foreign('media_id')
                  ->references('media_id')
                  ->on('media')
                  ->onDelete('cascade');
        
            $table->foreign('subtitle_id')
                  ->references('subtitle_id') // Ensure this matches the primary key in subtitles
                  ->on('subtitles')
                  ->onDelete('cascade');
        
            // Composite primary key
            $table->primary(['profile_id', 'media_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_watched_media');
    }
};