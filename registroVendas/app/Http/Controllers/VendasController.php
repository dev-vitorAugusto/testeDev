<?php

namespace App\Http\Controllers;

use App\Models\Vendas;
use App\Models\Parcela;
use App\Models\ProdutoVenda;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendasController extends Controller
{
     public function store(Request $request){
         
        $request->validate([
            // SALVANDO OS DADOS DE VENDAS
            'produto.*' => 'required|string',
            'quantidade.*' => 'required|integer|min:1',
            'preco.*' => 'required|integer|min:1',
            'cliente_id' => 'nullable|exists:clientes,id',

            // SALVANDO AS PARCELAS
            'qtd_parcelas' => 'required|integer|min:1|max:12',
            'valor_parcelas.*' => 'required|numeric|min:0.01',
            'valor_parcelas' => 'required|array',
            'vencimento_parcela.*' => 'required|date',
            'vencimento_parcela' => 'required|array',

        ]);

        // CALCULANDO SUBTOTAL
        $total = 0; 
        foreach($request->produto as $index =>$nome){
            $quantidade = $request->quantidade[$index];
            $preco = $request->preco[$index];
            $total+= $quantidade * $preco;
        }

        // CRIANDO ASVENDAS
        $venda = Vendas::create([
           
            'forma_pagamento' => $request->forma_pagamento,
            'cliente_id' => $request->cliente_id,
            'subtotal' => $total,
  
        ]);
        
        foreach($request->produto as $index => $produtos){
            ProdutoVenda::create([
                'venda_id' => $venda->id,
                'quantidade' => $request->quantidade[$index],
                'preco' => $request->preco[$index],
                'nome' => $produtos
            ]);
        }

        // CRIANDO AS PARCELAS
         foreach($request->valor_parcelas as $index => $valor) {
             Parcela::create([
            'venda_id' => $venda->id,
            'qtd_parcelas' => count($request->valor_parcelas),
            'valor_parcelas' => $valor,
            'vencimento_parcela' => $request->vencimento_parcela[$index]
            ]);
         }

        return redirect()->back()->with('success', 'Venda criada');
    }

    // EXIBIR 
    public function index(){
        $vendas = Vendas::with('cliente', 'parcelas')->get();
        return view('vendas', compact('vendas'));
    }

    // FUNÇÃO PARA EDITAR OS DADOS
    public function edit($id){
        $venda = Vendas::with(['cliente', 'parcelas'])->findOrFail($id);
        return view('vendas.edit', compact('venda', 'clientes'));
    }

    // FUNÇÃO PARA UPDATE
    public function update(Request $request, $id){
        $venda = Vendas::findOrFail($id);

       $request->validate([
        'produto' => 'required|string|max:255',
        'forma_pagamento' => 'required|string',
        'vencimento_parcela' => 'required|date',
        'parcela_id' => 'required|exists:parcelas,id',
        'preco' => 'required|numeric',
        'quantidade' => 'required|integer|min:1',
         'qtd_parcelas' => 'required|integer|min:1|max:12'
    ]);

    // Calcula o subtotal
    $subtotal = $request->preco * $request->quantidade;
    // CALCULANDO O VALOR DAS PARCELAS DE ACORDO COM O VALOR EDITADO
    $valor_parcelas =  $subtotal / $request->qtd_parcelas; 

    // AATUALIZANDO O VENCIMENTO DA PARCELA DE ACORDO COM O VALOR EDITADO e ATUALIZANDO A QUANTIDADE DE PARCELAS DE ACORDO COM O VALOR EDITADO
    $parcela = \App\Models\Parcela::findOrFail($request->parcela_id);
    $parcela->qtd_parcelas = $request->qtd_parcelas;
    $parcela->valor_parcelas = $valor_parcelas;
    $parcela->vencimento_parcela = $request->vencimento_parcela;
    $parcela->save();

    // ATAULIZANDO A VENDA
    $venda->update([
        'produto' => $request->produto,
        'preco' => $request->preco,
        'quantidade' => $request->quantidade,
        'subtotal' => $subtotal,
        'forma_pagamento' => $request->forma_pagamento,
    ]);

    // ATUALIZANDO PARCELAS
    foreach($request->parcela_id as $index => $id){
        $parcela =  \App\Models\Parcela::find($id);
        if($parcela){
            $parcela->vencimento_parcela = $request->vencimento_parcela[$index];
            $parcela->qtd_parcela = $request->qtd[$index];
            $parcela->valor = $request->valor[$index];
            $parcela->save();
        }
    }

    return redirect()->route('vendas')->with('success', 'Venda atualizada com sucesso!');
    }

    // FUNCÇÃO DE DESTROY
    public function destroy($id){
        $venda = Vendas::findOrFail($id);

        $venda->delete();

        return redirect()->route('vendas')->with('success', 'Venda excluida');
    }
}
