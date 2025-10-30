<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete(); 
            $table->foreignId('mesas_id')->nullable()->constrained('mesas')->nullOnDelete(); 

            $table->dateTime('fecha_reserva'); 
            $table->unsignedTinyInteger('comensales')->default(2); 

            $table->enum('estado', ['pendiente', 'confirmado', 'cancelado', 'completado'])
                ->default('pendiente'); 

            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservaciones');
    }
};
