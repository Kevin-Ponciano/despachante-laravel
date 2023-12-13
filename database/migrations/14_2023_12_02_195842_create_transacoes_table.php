<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transacoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transacao_original_id')->nullable();
            $table->enum('tipo', ['in', 'out'])->index(); // in = entrada, out = saida
            $table->foreignId('despachante_id')->constrained('despachantes')->onDelete('CASCADE');
            $table->foreignId('cliente_id')->nullable()->constrained('clientes')->onDelete('SET NULL');
            $table->foreignId('pedido_id')->nullable()->constrained('pedidos')->onDelete('SET NULL');
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->onDelete('SET NULL');
            $table->decimal('valor', 14, 2);
            $table->enum('status', ['pg', 'pe', 'ex'])->default('pe')->index(); // pg = pago, pe = pendente, cl = cancelado, at = atrasado, ex = excluido
            $table->date('data_vencimento');
            $table->date('data_pagamento')->nullable();
            $table->string('descricao');
            $table->string('observacao')->nullable();
            $table->enum('repetir', ['nr', 'rp', 'fx'])->default('nr'); // nr = nao repetir, rp = repetir, fx = fixo
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transacoes');
    }
};
