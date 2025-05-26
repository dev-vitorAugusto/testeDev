<?php

namespace App\Http\Controllers;

use App\Models\Cliente; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function store(Request $request){
        $request->validate([
           'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:clientes,cpf',
            'rg' => 'nullable|string|max:20',
        ]);

        Cliente::create([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'rg' => $request->rg,
        ]);

        return redirect()->back()->with('success', 'Cliente criado');
    }

    public function index(){
        $clientes = Cliente::all();
        return view('dashboard', compact('clientes'));
    }
}
