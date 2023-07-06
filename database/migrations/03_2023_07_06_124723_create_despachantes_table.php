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
        Schema::create('despachantes', function (Blueprint $table) {
            $table->id();
            $table->string('razao_social');
            $table->string('nome_fantasia')->nullable();
            $table->char('cnpj', 18)->unique()->index();
            $table->char('celular', 15)->nullable();
            $table->char('telefone', 14)->nullable();
            $table->foreignId('endereco_id')->unique()->constrained('enderecos')->onUpdate('cascade');
            $table->foreignId('plano_id')->nullable()->constrained('planos')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('despachantes');
    }
};
