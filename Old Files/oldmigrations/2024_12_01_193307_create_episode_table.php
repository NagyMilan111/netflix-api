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
        Schema::create('episodes', function (Blueprint $table) {
            $table->id('episode_id');
            $table->unsignedBigInteger('series_id'); // Ensure it's unsigned
            $table->foreign('series_id')
                ->references('id')
                ->on('series')
                ->onDelete('cascade'); // Optional: Cascade delete if the series is deleted
            $table->string('title');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episode');
    }
};
