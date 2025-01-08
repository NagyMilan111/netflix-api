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
        Schema::create('profiles_watched_medias', function (Blueprint $table) {
            $table->id('watched_id');
            $table->unsignedBigInteger('profile_id'); // Foreign key to profiles table
            $table->unsignedBigInteger('media_id'); // Foreign key to medias table
            $table->foreign('profile_id') // Define the foreign key constraint for profiles
                ->references('profile_id')
                ->on('profiles')
                ->onDelete('cascade');
            $table->foreign('media_id') // Define the foreign key constraint for medias
                ->references('media_id')
                ->on('medias')
                ->onDelete('cascade');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles_watched_medias');
    }
};
