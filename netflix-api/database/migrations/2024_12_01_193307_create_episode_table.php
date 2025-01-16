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
        if (!Schema::hasTable('episodes')) {
            Schema::create('episodes', function (Blueprint $table) {
                $table->id('episode_id');
                $table->foreignId('series_id')->constrained('series')->onDelete('cascade');
                $table->string('title');
                $table->timestamps();
            });
        }
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episode');
    }
};
