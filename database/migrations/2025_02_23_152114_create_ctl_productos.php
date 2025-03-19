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
        Schema::create('ctl_productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->double('precio',7,2);
            $table->text('image')->nullable();
            $table->foreignId('categoria_id')->constrained('id')->on('ctl_categoria')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ctl_productos');
    }
};
