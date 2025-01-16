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
        Schema::create('profile_watch_lists', function (Blueprint $table) {
            $table->id('list_id'); // Custom primary key
            $table->unsignedBigInteger('profile_id'); // Foreign key to profiles
            $table->unsignedBigInteger('media_id');   // Foreign key to media
            $table->unsignedBigInteger('subtitle_id')->nullable(); // Foreign key to subtitles
            $table->time('pause_spot')->default('00:00:00');
            $table->integer('times_watched')->default(0);
            $table->date('last_watch_date')->nullable();
            $table->timestamps();
        
            // Foreign key constraints
            $table->foreign('profile_id')
                  ->references('profile_id') // Reference the custom primary key in profiles
                  ->on('profiles')
                  ->onDelete('cascade');
        
            $table->foreign('media_id')
                  ->references('media_id') // References the primary key in media
                  ->on('media')
                  ->onDelete('cascade');
        
            $table->foreign('subtitle_id')
                  ->references('subtitle_id') // Ensure this matches the primary key in subtitles
                  ->on('subtitles')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_watch_lists');
    }
};
