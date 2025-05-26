<?php

namespace App\Models;
use App\Models\Venda;
use App\Models\Parcela;
use Illuminate\Database\Eloquent\Model;

class Parcela extends Model
{
        protected $fillable = [
        
        'venda_id',
        'qtd_parcelas',
        'valor_parcelas',
        'vencimento_parcela'
    ];


    public function venda(){
        return $this->belongsTo(Vendas::class);
    }
}
