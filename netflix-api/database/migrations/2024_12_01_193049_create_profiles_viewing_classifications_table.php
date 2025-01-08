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
        Schema::create('profiles_viewing_classifications', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('profile_id'); // Foreign key to profiles table
            $table->unsignedBigInteger('classification_id'); // Foreign key to viewing classifications table
            $table->timestamps();
        
            // Define foreign key constraints
            $table->foreign('profile_id')
                ->references('profile_id')
                ->on('profiles')
                ->onDelete('cascade');
        
            $table->foreign('classification_id')
                ->references('classification_id')
                ->on('viewing_classifications')
                ->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles_viewing_classifications');
    }
};
