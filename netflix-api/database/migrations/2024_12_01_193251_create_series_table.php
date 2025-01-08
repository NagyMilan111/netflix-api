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
        Schema::create('series', function (Blueprint $table) {
            $table->id('id'); // Primary key
            $table->string('title');
            $table->unsignedBigInteger('genre_id'); // Explicitly match the type of the genres.id column
            $table->foreign('genre_id')
                ->references('genre_id')
                ->on('genres')
                ->onDelete('cascade');
            $table->integer('number_of_seasons')->default(1);
            $table->timestamps();
        });            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
