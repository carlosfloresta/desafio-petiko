@extends('template')
@section('titulo', 'Form Pedido - Petiko')

@section('body')
    <div class="container mt-5">
        <h1>Formulário de Pedido</h1>
        <h5>Peça hoje mesmo seu brinde, entregaremos o mais breve possivel :)</h5>
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
                <input type="text" class="form-control" id="nome" name="nome" placeholder="nome" required>
                <label for="nome">Nome completo*</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="cep" name="cep" aria-describedby="validaCEP" placeholder="cep"
                    required>
                <label for="cep">CEP*</label>
                <div id="validaCEP" class="invalid-feedback"></div>
            </div>
            <div class="loadcep d-none" role="alert">
                <i class="fas fa-spinner fa-pulse"></i> pesquisando...
            </div>
        </form>
    </div>
@endsection
