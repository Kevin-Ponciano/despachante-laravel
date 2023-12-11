<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('despachante_id')->constrained('despachantes')->onDelete('CASCADE');
            $table->string('nome');
            $table->string('icone');
            $table->string('cor');
            $table->enum('status', ['at', 'in'])->default('at'); // at = ativo, in = inativo
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['despachante_id', 'nome']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
