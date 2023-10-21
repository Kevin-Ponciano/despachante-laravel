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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('numero_pedido')->index();
            $table->foreignId('cliente_id')->constrained('clientes')->onUpdate('cascade');

            $table->string('comprador_nome');
            $table->char('comprador_telefone', 15);
            $table->char('placa', 7);
            $table->string('veiculo');
            $table->decimal('preco_honorario', 12)->default(0);
            $table->char('status', 2);

            $table->boolean('solicitado_cancelamento')->default(false);
            $table->text('observacoes')->nullable();

            $table->dateTime('viewed_at')->nullable();
            $table->timestamps();
            $table->dateTime('concluded_at')->nullable();
            $table->softDeletes();

            $table->foreignId('criado_por')->constrained('users')->onUpdate('cascade');
            $table->foreignId('responsavel_por')->nullable()->constrained('users')->onUpdate('cascade');
            $table->foreignId('concluido_por')->nullable()->constrained('users')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
