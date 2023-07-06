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
            $table->string('nome');
            $table->char('status', 2);
            $table->float('preco_1_placa')->default(0);
            $table->float('preco_2_placa')->default(0);
            $table->float('preco_atpv')->default(0);
            $table->float('preco_loja')->default(0);
            $table->float('preco_terceiro')->default(0);
            $table->foreignId('despachante_id')->constrained('despachantes')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
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
