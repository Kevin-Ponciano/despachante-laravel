<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('despachante_id')->nullable()->constrained('despachantes')->onUpdate('cascade');
            $table->foreignId('cliente_id')->nullable()->constrained('clientes')->onUpdate('cascade');
            $table->foreignId('usuario_id')->nullable()->constrained('usuarios')->onUpdate('cascade');
            $table->foreignId('pedido_id')->nullable()->constrained('pedidos')->onUpdate('cascade');
            $table->string('level');
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
