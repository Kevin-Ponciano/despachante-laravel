<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('controle_fixas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transacao_original_id')->constrained('transacoes')->onDelete('CASCADE');
            $table->enum('tipo', ['in', 'out'])->index();
            $table->foreignId('despachante_id')->constrained('despachantes')->onDelete('CASCADE');
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('SET NULL');
            $table->decimal('valor', 14, 2);
            $table->enum('status', ['pg', 'pe', 'ex'])->default('pe')->index(); // pg = pago, pe = pendente, cl = cancelado, at = atrasado, ex = excluido
            $table->date('data_vencimento');
            $table->string('descricao');
            $table->string('observacao')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('controle_fixas');
    }
};
