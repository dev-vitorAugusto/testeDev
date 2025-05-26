<x-app-layout>
    <x-slot name="header">
    </x-slot>

<div class="container">
    <h1 class="text-light fs-2 py-3">Lista de vendas realizadas</h1>
        <div class="py-6 text-light">
        <table class="table table-striped table-dark">
            <thead>
                <tr class="text-center">
                    <th scope="col">#</th>
                    <th scope="col">Produto</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Parcelas</th>
                    <th scope="col">vencimento</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col">Forma de pagamento</th> 
                    <th scope="col">Ações</th>     
                </tr>
            </thead>
            <tbody>
                 @foreach($vendas as $venda)
                <tr class="text-center">
                    <th scope="row">{{$venda->id}}</th>
                    <td>{{$venda->produto}}</td>
                    <td>{{$venda->cliente->nome ?? 'Cliente não encontrado'}}</td> 
                    <td>{{$venda->parcelas->first()->qtd_parcelas ?? 'N/A'}}x R${{$venda->parcelas->first()->valor_parcelas ?? 'N/A'}}</td>
                    <td>{{$venda->parcelas->first()->vencimento_parcela ?? 'N/A'}}</td>
                    <td>R${{$venda->subtotal}}</td>
                    <td>{{$venda->forma_pagamento}}</td>
                    <td>
                        <a href="" class="btn btn-warning"  data-bs-toggle="modal" data-bs-target="#editarModal-{{$venda->id}}"><i class="bi bi-pencil-square"></i></a>

                        <form action="{{route('vendas.destroy', $venda->id)}}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir a venda?')"><i class="bi bi-trash"></i></button>
                        </form>
                            <!-- MODAL DE EDIÇÃO -->
                            <div class="modal fade" id="editarModal-{{$venda->id}}" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('vendas.update', $venda->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content text-dark">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="row">

                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label>Preço Unitário</label>
                                                        <input type="number" step="0.01" name="preco" class="form-control" value="{{ $venda->preco }}" required>
                                                    </div>
                                                </div>

                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label>Produto</label>
                                                        <input type="text" name="produto" class="form-control" value="{{ $venda->produto }}" required>
                                                    </div>
                                                </div>
                                                
                                                <div class="col">
                                                        <div class="mb-3">
                                                            <label>Quantidade</label>
                                                             <input type="number" name="quantidade" class="form-control" value="{{ $venda->quantidade }}" required>
                                                         </div>
                                                </div>

                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-4">
                                                        <div class="mb-3">
                                                            <label>Forma de Pagamento</label>
                                                            <input type="text" name="forma_pagamento" class="form-control" value="{{ $venda->forma_pagamento }}" required>
                                                        </div>
                                                </div>

                                                <div class="col-4">
                                                      <div class="mb-3">
                                                        <label for="">Data de vencimento</label>
                                                        <input type="hidden" name="parcela_id" value="{{$venda->parcelas->first()->id}}">
                                                        <input type="date" name="vencimento_parcela" value="{{$venda->parcelas->first()->vencimento_parcela}}">
                                                      </div>
                                                </div>
                                                
                                                  <div class="col-4">
                                                    <input type="hidden" name="parcela_id" value="{{$venda->parcelas->first()->id}}">
                                                      <div class="mt-4 d-flex flex-column justify-content-end align-items-center">
                                                            <label for="" class="">Parcelas</label>
                                                            <input type="number" name="qtd_parcelas" class="w-50" value="{{ $venda->parcelas->first()->qtd_parcelas }}" required>
                                                      </div>
                                                </div>
                                                
                                                </div>
                                               
                                              
                                            
                                          
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            </div>
                    </td>      
                </tr>
                 @endforeach
            </tbody>
        </table>



    </div>
</div>

</x-app-layout>