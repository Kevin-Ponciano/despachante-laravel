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
        Schema::create('despachantes', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('endereco_id')->constrained('enderecos')->onUpdate('cascade');
            $table->string('razao_social');
            $table->string('nome_fantasia')->nullable();
            $table->char('cnpj', 18)->unique()->index();
            $table->string('email')->unique();
            $table->char('celular', 15);
            $table->char('celular_secundario', 15)->nullable();
            $table->string('site')->nullable();
            $table->char('status', 2)->default('at');
            $table->timestamps();
            $table->softDeletes();
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
