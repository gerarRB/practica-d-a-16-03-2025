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
        Schema::create('_mnt_detalle_pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('id')->on('mnt_pedidos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('producto_id')->constrained('id')->on('ctl_productos')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('cantidad');
            $table->double('precio',7,2);
            $table->double('sub_total',7,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_mnt_detalle_pedidos');
    }
};
