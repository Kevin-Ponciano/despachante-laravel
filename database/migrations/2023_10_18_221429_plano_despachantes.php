<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plano_despachantes', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->unique()->autoIncrement();
            $table->foreignId('plano_id')->constrained('planos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('despachante_id')->unique()->constrained('despachantes')->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('preco', 12)->default(0);
            $table->smallInteger('qtd_clientes')->unsigned();
            $table->smallInteger('qtd_usuarios')->unsigned();
            $table->integer('qtd_processos_mes')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plano_despachantes');
    }
};
