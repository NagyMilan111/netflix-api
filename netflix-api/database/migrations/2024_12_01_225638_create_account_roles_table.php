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
        Schema::create('account_roles', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('account_id'); // Foreign key to accounts table
            $table->unsignedBigInteger('role_id'); // Foreign key to roles table

            // Foreign key constraints
            $table->foreign('account_id')
                ->references('account_id') // Match the primary key in accounts
                ->on('accounts')
                ->onDelete('cascade');
            
            $table->foreign('role_id')
                ->references('role_id') // Match the primary key in roles
                ->on('roles')
                ->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('account_roles');
    }
};
