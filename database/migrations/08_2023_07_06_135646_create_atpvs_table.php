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
        Schema::create('atpvs', function (Blueprint $table) {
            $table->id();
            $table->char('renavam', 11);
            $table->char('numero_crv', 12);
            $table->char('codigo_crv',12)->nullable();

            $table->float('hodometro')->nullable()->default(0);
            $table->dateTime('data_hodometro')->nullable();

            $table->string('vendedor_email');
            $table->char('vendedor_telefone',15);
            $table->char('vendedor_cpf_cnpj', 18);
            $table->char('comprador_cpf_cnpj', 18);
            $table->string('comprador_email');
            $table->foreignId('comprador_endereco')->constrained('enderecos')->onUpdate('cascade');
            $table->float('preco_venda')->default(0);
            $table->foreignId('pedido_id')->constrained('pedidos')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
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
