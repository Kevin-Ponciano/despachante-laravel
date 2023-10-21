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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('despachante_id')->constrained('despachantes')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('numero_cliente')->index();
            $table->string('nome');
            $table->char('status', 2);
            $table->decimal('preco_1_placa', 12)->default(0);
            $table->decimal('preco_2_placa', 12)->default(0);
            $table->decimal('preco_atpv', 12)->default(0);
            $table->decimal('preco_loja', 12)->default(0);
            $table->decimal('preco_terceiro', 12)->default(0);
            $table->decimal('preco_renave_entrada', 12)->default(0);
            $table->decimal('preco_renave_saida', 12)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
