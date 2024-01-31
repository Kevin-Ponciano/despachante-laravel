<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('controle_repeticoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transacao_anterior_id')->nullable();
            $table->foreignId('transacao_id')->constrained('transacoes')->onDelete('CASCADE');
            $table->unsignedSmallInteger('transacao_posterior_id')->nullable();
            $table->enum('status', ['at', 'in', 'ex'])->default('at')->index(); // at = ativo, in = inativo, ex = excluido
            $table->unsignedSmallInteger('posicao')->default(1);
            $table->bigInteger('transacao_original_id');
            $table->unsignedSmallInteger('total_repeticoes')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('controle_repeticoes');
    }
};
