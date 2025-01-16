<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('watchlists', function (Blueprint $table) {
            $table->unsignedBigInteger('profile_id');
            $table->unsignedBigInteger('media_id');
            $table->unsignedBigInteger('series_id')->nullable();
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

            $table->foreign('series_id')
                  ->references('series_id')
                  ->on('series')
                  ->onDelete('cascade');

            // Composite primary key
            $table->primary(['profile_id', 'media_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('watchlists');
    }
};