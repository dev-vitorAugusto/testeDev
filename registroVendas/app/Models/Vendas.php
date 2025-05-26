<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Vendas extends Model
{
      protected $fillable = [
        
        'produto',
        'quantidade',
        'preco',
        'forma_pagamento',
        'cliente_id',
        'subtotal'
 
    ];

    public function cliente(){
      return $this->belongsTo(Cliente::class);
    }

     public function parcelas(){
      return $this->hasMany(Parcela::class,  'venda_id');
    }

}
