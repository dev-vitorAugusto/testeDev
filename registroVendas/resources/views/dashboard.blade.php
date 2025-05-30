<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="py-12 text-white">
       <div class="container">
        <div class="row">
            <div class="col">
                <h1>VENDAS</h1>
            </div>
        </div>

        <div class="row">
            <div class="col border border-1 p-5 mt-3 bg-white rounded text-dark">
               <div class="d-flex flex-column">
                 <h2 class="fw-bold mb-1">Cliente</h2>
                 <div class="d-flex m-2">
                         <select class="me-2" name="cliente_id" id="selectCliente" style="width: 300px; height: 40px">
                        <option value="">Selecionar cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id}}" data-nome ="{{ $cliente->nome }}" data-cpf="{{ $cliente->cpf }}" data-rg="{{ $cliente->rg }}">{{ $cliente->nome }}</option>
                        @endforeach
                 </select>

                 <button data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus-square-fill text-warning fs-3"></i></button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar novo cliente</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3" method="POST" action="{{ route('clientes.store') }}">
                            @csrf 
                            <div class="col-md-4">
                                <label for="nomeCliente" class="form-label">Nome</label>
                                <input type="text" name="nome" class="form-control" id="nomeCliente" placeholder="Vitor..." required>
                            </div>

                            <div class="col-md-4">
                                <label for="validatiocpfClientenCustom01" class="form-label">CPF</label>
                                <input type="text" name="cpf" class="form-control" id="cpfCliente" placeholder="000.000.000-00" required>
                            </div>

                            <div class="col-md-4">
                                <label for="rgCliente" class="form-label">RG</label>
                                <input type="text" name="rg" class="form-control" id="rgCliente" placeholder="00.000.000-0" required>
                            </div>
  
                            <div class="col-12">
                                <button class="btn btn-success" type="submit">Adicionar</button>
                            </div>
                    </form>
                    </div>
                    </div>
                </div>
                </div>
                 </div>
               </div>
            </div>
        </div>

            <div class="row">
                 <div class="col border border-1 p-5 mt-3 bg-white rounded text-dark">
                    <h3 class="fw-bold mb-1">Dados do cliente selecionado:</h3>
                        <div class="alert alert-warning" id="alerta" role="alert">Nenhum cliente selecionado.</div>        
                    <div id="dadosCliente" class="" style="display: none;">
                        <div class="d-flex flex-column p-3">
                           <table class="table table-sm">
                                <thead>
                                    <tr>
                                    <th scope="col">Nome</th>
                                    <th scope="col">CPF</th>
                                    <th scope="col">RG</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <td id="clienteNome"></td>
                                    <td id="clienteCpf"></td>
                                    <td id="clienteRg"></td>
                                    </tr>
                                </tbody>
                         </table>
                        </div>
                    </div>
                </div>
            </div>

             <div class="row">
                 <div class="col border border-1 p-5 mt-3 bg-white rounded text-dark">
                    <h3 class="fw-bold mb-1">Registrar venda para o cliente: <span id="clienteNomeId"></span></h3>
                    <form action="{{ route('vendas.store') }}" method="POST">
                        @csrf
                        @if ($errors->any())
    <div class="alert alert-danger mt-2">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                        <div class="d-flex flex-column" id="produtosContainer">
                            <div class="produto-row d-flex">
                                <select name="produto[]" id="">
                                    <option value="" disabled selected>Selecionar produto</option>
                                    <option value="boné">Boné</option>
                                    <option value="tênis">Tênis</option>
                                    <option value="camisa polo">Camisa Polo</option>
                                    <option value="Jeans">Jeans</option>
                                    <option value="Relógio">Relógio</option>
                                </select>
                                <input type="number" name="quantidade[]" id="quantidade" class="ms-2 quantidade" min= 1 value=1>
                                <input type="number" step="0.01" name="preco[]" class="ms-2 preco" id="preco" placeholder="Valor unitário">
                                 <select name="forma_pagamento" id="" class="ms-2 w-25">
                                    <option value="">Forma de pagamento</option>
                                    <option value="cartão">Cartão</option>
                                    <option value="pix">Pix</option>
                                </select>

                                <input type="number" id="subtotal" name="subtotal" class="ms-2 w-25 disabled input" placeholder="Subtotal" readonly>
                           </div>

                               
                                <input type="hidden" name="cliente_id" id="hiddenClienteId">

                        </div> 
                                <button type="button" class="btn btn-sm btn-warning mt-2" onclick="adicionarNovoProduto()">+ Novo produto</button>
                                  <!-- Button trigger modal -->
                                <button type="button" class="mt-2 btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalParcelas">
                                Ver parcelas <i class="bi bi-coin"></i>
                                </button>

                                        <!-- Modal -->
                                <div class="modal fade" id="modalParcelas" tabindex="-1" aria-labelledby="modalParcelasLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="modalParcelasLabel">Parcelas e data de vencimento</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <select name="qtd_parcelas" id="parcelaSelecionada" min="1" max="12">
                                            @for($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}">{{ $i }}x</option>
                                            @endfor
                                        </select>
                                        <div id="parcelasInput"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="fs-4 " id="informacaoParcelas"></div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <!-- FIM MODAL -->
                                <button type="submit" class="btn btn-info btn-sm mt-2">Salvar vendas</button>
                    </form>      
                              
              

    </div>
</x-app-layout>

<script>
    // AQUI EU ESTOU INICIANDO A TAG SCRIPT

    // AQUI EU ESTOU CRIANDO UMA FUNÇÃO QUE DE CERTA FORMA "ESCUTA" SE HOUVE ALGUMA MUDANÇA NA TAG <SELECT>, CASO HOUVER ELE EXECUTA O CÓDIGO 
    document.getElementById('selectCliente').addEventListener('change', function(){

        // AQUI ESTOU CRIANDO UMA VARIÁVEL QUE RECEBE A OPÇÃO SELECIONADA DO <SELECT><OPTION>THIS</OPTION></SELECT>
        let opcaoSelecionada = this.options[this.selectedIndex]; 

        // AQUI EU ESTOU PEGANDO OS VALORES DAS OPÇÕES SELECIONADAS
        let nome = opcaoSelecionada.getAttribute('data-nome');
        let cpf = opcaoSelecionada.getAttribute('data-cpf');
        let rg = opcaoSelecionada.getAttribute('data-rg');

        // AQUI EU ESTOU DIZENDO QUE SE HOUVER UM NOME, OU SEJA, O ITEM SELECIONADO EXISTIR O JS PEGA OS VALORES E INSERE NOS ELEMENTOS HTML CORRESPONDENTES AS ID'S
        if(nome){
            document.getElementById('clienteNome').innerText = nome;
            document.getElementById('clienteCpf').innerText = cpf;
            document.getElementById('clienteRg').innerText = rg; 

            document.getElementById('clienteNomeId').innerText = nome;

             document.getElementById('dadosCliente').style.display = "block";
             document.getElementById('alerta').style.display = "none";
        } else{
             document.getElementById('dadosCliente').style.display = "none";
        }

       
    })

    // PEGANDO O ID DO CLIENTE SELECIONADO ADICIONANDO O VALOR A UM INPUT ESCONDIDO
     document.getElementById('selectCliente').addEventListener('change', function () {
        document.getElementById('hiddenClienteId').value = this.value;
    });

   


    // FUNÇÃO PARA ADICIONAR MAIS DE UM PRODUTO 

    // DEFINIFNO VARIAVEL DE INDEX PARA A LISTAGEM DE PRODUTOS
    let produtoIndex = 1; 

    function adicionarNovoProduto(){
        // PEGANDO O CONTAINER QUE ABRAÇA OS INPUTS RELACIONADOS A VENDA
        const container = document.getElementById('produtosContainer');

        // CRIANDO UMA DIV NO HTML
        const novaLinha = document.createElement('div');
        novaLinha.classList.add('produto-row', 'd-flex', 'mt-2');

        novaLinha.innerHTML=`
            <select name="produto[]" id="">
                                    <option value="" disabled selected>Selecionar produto</option>
                                    <option value="boné">Boné</option>
                                    <option value="tênis">Tênis</option>
                                    <option value="camisa polo">Camisa Polo</option>
                                    <option value="Jeans">Jeans</option>
                                    <option value="Relógio">Relógio</option>
                                </select>
                                <input type="number" name="quantidade[]" id="quantidade" class="ms-2 quantidade" min= 1 value=1>
                                <input type="number" step="0.01" name="preco[]" class="ms-2 preco" id="preco" placeholder="Valor unitário">
        `
        // ADICIONANDO A NOVA LINHA DENTRO DO CONTAINER
        container.appendChild(novaLinha);
        produtoIndex++;


       
    }

     // FUNÇÃO PARA ATUALIZAR O SUBTOTAL
    function atualizarSubtotal(){
        // PREÇO DIGITADO PELO USUÁRIO
        let precos = document.getElementsByClassName('preco');
        // QUANTIDADE INSERIDA PELO USUÁRIO
        let quantidades = document.getElementsByClassName('quantidade'); 
        // VARÁVEL RECEBENDO O CÁLCULO DO SUBTOTAL
        let subtotal = 0; 

        // SOMANDO OS PRODUTOS
        for(let i = 0; i < precos.length; i++){
            const preco = parseFloat(precos[i].value) || 0;
            const quantidade = parseFloat(quantidades[i].value) || 0;
            subtotal+= preco * quantidade;
        }

         document.getElementById('subtotal').value = subtotal.toFixed(2);

        // IDENTIFICA A PARCELA SELECIONADA NO SELECT
        const parcelaSelecionada = parseInt(document.getElementById('parcelaSelecionada').value) || 0;
        const informacaoParcela = document.getElementById("informacaoParcela");

        // 
       if(parcelaSelecionada > 0){
        // FAZENDO O CÁLCULO DA PARCELA SELECIONADA DIVIDIDA PELO PREÇO (SUBTOTAL)
         const valorParcela = subtotal /  parcelaSelecionada;

        // EXIBINDO O RESULTADO EDITADO PELO DOM NO HTML
        informacaoParcelas.innerText = `Parcela:  ${parcelaSelecionada}x de R$ ${valorParcela.toFixed(2)}`;
        // ADICIONANDO O VALOR FINAL A UM INPUT ESCONDIDO COM O NAME DO CAMPO NO BANCO DE DADOS
        document.getElementById('valorParcelaInput').value = valorParcela.toFixed(2);
       }
    }

        // PARCELAS
        document.getElementById('parcelaSelecionada').addEventListener('change', function() {
            const qtd = parseInt(this.value);
            const docker = document.getElementById('parcelasInput');
            docker.innerHTML= ``;

            // PREÇO DIGITADO PELO USUÁRIO
            let precos = document.getElementsByClassName('preco');
            // QUANTIDADE INSERIDA PELO USUÁRIO
            let quantidades = document.getElementsByClassName('quantidade'); 
            // VARÁVEL RECEBENDO O CÁLCULO DO SUBTOTAL
            let subtotal = 0; 

            // SOMANDO OS PRODUTOS
            for(let i = 0; i < precos.length; i++){
                const preco = parseFloat(precos[i].value) || 0;
                const quantidade = parseFloat(quantidades[i].value) || 0;
                subtotal+= preco * quantidade;
            }

            const valorParcela = subtotal /  qtd;
            // CRIANDO ARRAY PARA RECEBER AS DATAS
            const datas = []; 
            
            for(let i = 1; i <= qtd; i++){
                const div = document.createElement('div');
                div.classList.add('m-2')
                div.innerHTML =`
                    <label>Parcela ${i}:</label>
                    <input type="number" name="valor_parcelas[]" value="${valorParcela.toFixed(2)}" step="0.01" required placeholder="R$${valorParcela.toFixed(2)}" />
                    <input type="date" name="vencimento_parcela[]" required id="dataParcela${i}"/>
                `;
                docker.appendChild(div);

                // GUARDANDO OS VALORES DAS DATAS NO ARRAY CRIADO MAIS ACIMA
                datas.push(document.getElementById(`dataParcela${i}`));
            }

            // EVENTO DE MUDANÇA DE DATAS
            datas[0].addEventListener('change', function(){
                const dataBase = new Date(this.value);
                if (isNaN(dataBase)) return; 

                const diaAtualMes = dataBase.getDate();

                for(let i =1; i < datas.length; i++){
                    const novaData = new Date(dataBase);
                    novaData.setMonth(novaData.getMonth() + i);

                    while(dataBase.getDate() !== diaAtualMes){
                        novaData.setDate(novaData.getDate() + 1)
                    }

                    const ano = novaData.getFullYear();
                    const mes = String(novaData.getMonth() + 1).padStart(2, '0');
                    const dia = String(novaData.getDate()).padStart(2, '0');
                    datas[i].value = `${ano}-${mes}-${dia}`;
                }
            });

            // Atualiza também o informativo e input oculto
            const informacaoParcela = document.getElementById("informacaoParcela");
            if (informacaoParcela) {
                informacaoParcela.innerText = `Parcela: ${qtd}x de R$ ${valorParcela.toFixed(2)}`;
            }
            document.getElementById('valorParcelaInput').value = valorParcela.toFixed(2);
        });

    // ADICIONANDO AOS ELEMENTOS O EVENTO ACIMA, PARA QUE ELES O EXECUTEM QUANDO ALGO ACONTECER
    document.addEventListener('input', function (e){
        if(e.target.classList.contains('preco') || e.target.classList.contains('quantidade')){
            atualizarSubtotal();
        }
    })
    document.getElementById('parcelaSelecionada').addEventListener('change', atualizarSubtotal);
    // ATUALIZAÇÃO DA PÁGINA
    window.addEventListener('load', atualizarSubtotal);
</script>
