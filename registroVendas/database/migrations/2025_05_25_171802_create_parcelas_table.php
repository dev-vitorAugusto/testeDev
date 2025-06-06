<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    //  CRIEI A TABELA PARCELAS SEPARA DE VENDAS, PARA ESTABELECER RELAÇÃO ENTRE ELAS
    public function up(): void
    {
        Schema::create('parcelas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venda_id');
            $table->integer('qtd_parcelas');
            $table->decimal('valor_parcelas', 10, 2);
            $table->date('vencimento_parcela');
            $table->timestamps();

            // AQUI EU ESTOU RELACIONANDO ID'S
            $table->foreign('venda_id')->references('id')->on('vendas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcelas');
    }
};
