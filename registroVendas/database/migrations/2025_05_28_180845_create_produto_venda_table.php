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
        Schema::create('produto_venda', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venda_id');
            $table->string('nome');
            $table->integer('quantidade')->unsigned();
            $table->decimal('preco', 10, 2);
            $table->timestamps();

            // RELACIONANDO COM A TABELA DE VENDAS
            $table->foreign('venda_id')->references('id')->on('vendas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produto_venda');
    }
};
