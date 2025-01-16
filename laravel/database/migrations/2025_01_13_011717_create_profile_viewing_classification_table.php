<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profile_viewing_classification', function (Blueprint $table) {
            $table->unsignedBigInteger('profile_id'); // Foreign key to profiles
            $table->unsignedBigInteger('classification_id'); // Foreign key to viewing_classifications
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('profile_id')
                  ->references('profile_id') // Reference the custom primary key in profiles
                  ->on('profiles')
                  ->onDelete('cascade');

            $table->foreign('classification_id')
                  ->references('classification_id') // Reference the primary key in viewing_classifications
                  ->on('viewing_classifications')
                  ->onDelete('cascade');

            // Composite primary key
            $table->primary(['profile_id', 'classification_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_viewing_classification');
    }
};