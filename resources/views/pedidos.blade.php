@extends('template')
@section('titulo', 'Pedidos - Petiko')
@section('linkbtnav', route('form-pedido'))
@section('nomebtnav', 'Form Pedido')

@section('body')
    <div class="container mt-5">

        <p>ATENÇÃO: Não colocar dados pessoais neste formulário pois se trata de um desafio técnico para a empresa PETIKO
            que não tem relação alguma com este formulário!</p>
        <h1>Pedidos</h1>

        <div class="table-responsive">
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th scope="col">Nº Pedido</th>
                        <th scope="col">Nome</th>
                        <th scope="col">CEP</th>
                        <th scope="col">Logradouro</th>
                        <th scope="col">Complemento</th>
                        <th scope="col">Bairro</th>
                        <th scope="col">Cidade</th>
                        <th scope="col">Estado</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($pedido as $pedidos)
                        <tr>
                            <th scope="row">{{ $pedidos->id }}</th>
                            <td>{{ $pedidos->nome }}</td>
                            <td>{{ $pedidos->cep }}</td>
                            <td>{{ $pedidos->logradouro }}</td>
                            <td>{{ $pedidos->complemento }}</td>
                            <td>{{ $pedidos->bairro }}</td>
                            <td>{{ $pedidos->cidade }}</td>
                            <td>{{ $pedidos->estado }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <br><br>
@endsection
