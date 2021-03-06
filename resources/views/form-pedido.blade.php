@extends('template')
@section('titulo', 'Form Pedido - Petiko')
@section('linkbtnav', route('pedidos'))
@section('nomebtnav', 'Pedidos')

@section('body')
    <div class="container mt-5">
        <p>ATENÇÃO: Não colocar dados pessoais neste formulário pois se trata de um desafio técnico para a empresa PETIKO
            que não tem relação alguma com este formulário!</p>
        <div class="row">
            <div class="col-sm-4" style="background-color: rgb(65, 116, 255)">
                <div style="">

                    <img src="https://box.petiko.com.br/images/cachorro-meio-border.jpg" alt="" width="100%">
                </div>
            </div>
            <div class="col-sm-8">
                <h1>Formulário de Pedido</h1>
                <h5>Peça hoje mesmo sua box, entregaremos o mais breve possivel :)</h5>
                {{-- Alerts --}}
                <div class="alert alert-danger messageBoxError d-none" role="alert"></div>
                <div class="alert alert-success messageBox d-none" role="alert"></div>
                <div class="alert alert-primary load d-none" role="alert">
                    <i class="fas fa-spinner fa-pulse"></i> Enviando, aguarde!
                </div>
                {{-- fim alerts --}}
                <span> Campos com (*) são obrigatórios! </span>
                <form action="" id="form-cadastrar-pedido" name="form-cadastrar-pedido">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="nome">
                        <label for="nome">Nome completo*</label>
                        <div id="validaNome" class="invalid-feedback"></div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="cep" name="cep" aria-describedby="validaCEP"
                            placeholder="cep">
                        <label for="cep">CEP*</label>
                        <div id="validaCEP" class="invalid-feedback"></div>
                    </div>
                    <div class="loadcep d-none" role="alert">
                        <i class="fas fa-spinner fa-pulse"></i> pesquisando...
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br><br>
@endsection
