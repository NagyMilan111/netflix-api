<?php

// database/migrations/xxxx_xx_xx_create_views_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewsTable extends Migration
{
    public function up()
    {
        Schema::create('views', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id'); // Foreign key to profiles
            $table->unsignedBigInteger('media_id');   // Foreign key to media
            $table->integer('times_watched')->default(0);
            $table->dateTime('last_watch_date')->nullable();
            $table->timestamps();
        
            // Foreign key constraints
            $table->foreign('profile_id')
                  ->references('profile_id') // Reference the custom primary key in profiles
                  ->on('profiles')
                  ->onDelete('cascade');
        
            $table->foreign('media_id')
                  ->references('media_id') // References the primary key in media (media_id)
                  ->on('media')
                  ->onDelete('cascade');
        
            // Composite unique key to prevent duplicate entries
            $table->unique(['profile_id', 'media_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('views');
    }
}