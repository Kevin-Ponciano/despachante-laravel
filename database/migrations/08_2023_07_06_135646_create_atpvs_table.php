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
        Schema::create('atpvs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->onUpdate('cascade');
            $table->char('renavam', 11);
            $table->char('numero_crv', 12);
            $table->char('codigo_crv', 12)->nullable();
            $table->char('movimentacao', 3)->nullable();

            $table->string('hodometro')->nullable()->default(0);
            $table->dateTime('data_hodometro')->nullable();

            $table->string('vendedor_email');
            $table->char('vendedor_telefone', 15);
            $table->char('vendedor_cpf_cnpj', 18);
            $table->char('comprador_cpf_cnpj', 18);
            $table->string('comprador_email');
            $table->foreignId('comprador_endereco_id')->constrained('enderecos')->onUpdate('cascade');
            $table->decimal('preco_venda', 12)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atpvs');
    }
};
