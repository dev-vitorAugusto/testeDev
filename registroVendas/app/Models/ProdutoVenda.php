<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdutoVenda extends Model
{
    

    protected $table = 'produto_venda';

    protected $fillable = [
        'venda_id',
        'produto',
        'quantidade',
        'preco',
        'nome'
    ];

    public function venda(){
        return $this->belongsTo(vendas::class);
    }
}
