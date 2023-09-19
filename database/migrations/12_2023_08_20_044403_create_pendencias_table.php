<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pendencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nome');
            $table->char('tipo', 2);
            $table->char('status', 2);
            $table->string('input')->nullable();
            $table->string('observacao')->nullable();
            $table->dateTime('criado_em');
            $table->dateTime('atualizado_em')->nullable();
            $table->dateTime('concluido_em')->nullable();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendencias');
    }
};
