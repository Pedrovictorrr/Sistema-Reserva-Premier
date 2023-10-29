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
        Schema::create('convidados', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('documento')->nullable();
            $table->string('telefone')->nullable();
            $table->string('avatar_url')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convidados');
    }
};
