<?php

namespace App\Http\Controllers;

use App\Models\Vendas;
use App\Models\Parcela;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendasController extends Controller
{
     public function store(Request $request){
         
        $request->validate([
           'produto' => 'required|string',
            'quantidade' => 'required|integer|min:1',
            'preco' => 'required|numeric',
            'forma_pagamento' => 'required|string',
            'cliente_id' => 'nullable|exists:clientes,id',
            'subtotal' => 'required|numeric',

            // SALVANDO AS PARCELAS
            
             'qtd_parcelas' => 'required|integer|min:1|max:12',
            'valor_parcelas' => 'required|numeric|min:0.01',
            'vencimento_parcela' => 'required|date',

        ]);

        
        $venda = Vendas::create([
           
           'produto' => $request->produto,
            'quantidade' => $request->quantidade,
            'preco' => $request->preco,
            'forma_pagamento' => $request->forma_pagamento,
            'cliente_id' => $request->cliente_id,
            'subtotal' => $request->subtotal,
  
        ]);

          Parcela::create([
            'venda_id' => $venda->id,
            'qtd_parcelas' => $request->qtd_parcelas,
            'valor_parcelas' => $request->valor_parcelas,
            'vencimento_parcela' => $request->vencimento_parcela
        ]);

        return redirect()->back()->with('success', 'Venda criada');
    }

    public function index(){
        $vendas = Vendas::with('cliente', 'parcelas')->get();
        return view('vendas', compact('vendas'));
    }

    // FUNÇÃO PARA EDITAR OS DADOS
    public function edit($id){
        $venda = Vendas::with(['cliente', 'parcelas'])->findOrFail($id);
        return view('vendas.edit', compact('venda', 'clientes'));
    }

    // UPDATE
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
    $valor_parcelas =  $subtotal / $request->qtd_parcelas; 

    // Atualiza vencimento da parcela
    $parcela = \App\Models\Parcela::findOrFail($request->parcela_id);
    $parcela->qtd_parcelas = $request->qtd_parcelas;
    $parcela->valor_parcelas = $valor_parcelas;
    $parcela->vencimento_parcela = $request->vencimento_parcela;
    $parcela->save();

    // Atualiza a venda
    $venda->update([
        'produto' => $request->produto,
        'preco' => $request->preco,
        'quantidade' => $request->quantidade,
        'subtotal' => $subtotal,
        'forma_pagamento' => $request->forma_pagamento,
    ]);

    return redirect()->route('vendas')->with('success', 'Venda atualizada com sucesso!');
    }

    // DESTROY
    public function destroy($id){
        $venda = Vendas::findOrFail($id);

        $venda->delete();

        return redirect()->route('vendas')->with('success', 'Venda excluida');
    }
}
