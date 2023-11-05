<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arquivos', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_bin';
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos');
            $table->string('nome');
            $table->string('path')->unique();
            $table->string('folder');
            $table->string('mime_type');
            $table->text('url');
            $table->dateTime('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arquivos');
    }
};
