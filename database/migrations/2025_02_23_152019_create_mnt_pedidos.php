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
        Schema::create('mnt_pedidos', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fecha_pedido');
            $table->boolean('estado')->default(true);
            $table->double('total',7,2);
            $table->foreignId('client_id')->constrained('id')->on('mnt_clientes')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_mnt_pedidos');
    }
};
