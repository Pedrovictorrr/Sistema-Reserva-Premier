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
        Schema::create('convidado_reserva', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('convidado_id');
            $table->unsignedBigInteger('reserva_id');
            $table->foreign('convidado_id')->references('id')->on('convidados')->onDelete('cascade');
            $table->foreign('reserva_id')->references('id')->on('reservas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convidado_reserva');
    }
};
