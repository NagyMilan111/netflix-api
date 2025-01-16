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
        Schema::create('media_qualities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('media_id'); // Foreign key (must match media.media_id)
            $table->boolean('has_uhd_version')->default(false);
            $table->boolean('has_hd_version')->default(false);
            $table->boolean('has_sd_version')->default(true);
            $table->timestamps();
        
            // Foreign key constraint
            $table->foreign('media_id')
                  ->references('media_id') // References the primary key in media
                  ->on('media')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_qualities');
    }
};
