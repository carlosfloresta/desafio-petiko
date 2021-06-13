<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Petiko</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <!-- As a heading -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Petiko</span>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>Formulário de Pedido</h1>


        <div class="alert alert-danger messageBoxError d-none" role="alert"></div>

        <div class="alert alert-success messageBox d-none" role="alert"></div>

        <div class="alert alert-primary load d-none" role="alert">
          <i class="fas fa-spinner fa-pulse"></i> Enviando, aguarde!
      </div>

        <span> Campos com (*) são obrigatórios! </span>
        <form action="" id="form-cadastrar-pedido" name="form-cadastrar-pedido">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="nome" name="nome" placeholder="nome" required>
                <label for="nome">Nome completo*</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="cep" name="cep" aria-describedby="validaCEP"
                    placeholder="cep" required>
                <label for="cep">CEP*</label>
                <div id="validaCEP" class="invalid-feedback"></div>
            </div>

            <div class="loadcep d-none" role="alert">
              <i class="fas fa-spinner fa-pulse"></i> pesquisando...
          </div>



        </form>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>


    <script>
        //mascara para o CEP
        $("#cep").mask("99999-999");


        //optei por utilizar o keyup inves do blur para ficar mais intuitivo. coloquei um time para evitar que ao colar o cep fosse feita duas ou mais requisições 
        $("#cep").on("keyup", function(e) {
            e.preventDefault();
            clearTimeout($(this).data('timeout'));
            var cep = $(this).val().replace(/\D/g, '');
            $(".endereco").remove();
            var validacep = /^[0-9]{8}$/;
            $(this).data('timeout', setTimeout(function() {
                if (validacep.test(cep) && $(".endereco").length === 0) {
                    ajax_cep(cep);
                } else {
                    $(".endereco").remove();
                }
            }, 200));
        });


        function ajax_cep(cep) {

            //enviando csrf com a requisição
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '{{ route('busca-cep') }}',
                data: {
                    cep: cep
                },
                beforeSend: function() {
                  $(".loadcep").removeClass("d-none");
                    $("#cep").attr("disabled", true);
                },
                complete: function() {
                  $(".loadcep").addClass("d-none");
                    $("#cep").attr("disabled", false);
                },
                //recebendo os dados do backend
                success: function(data) {

                    if (!("erro" in data)) {
                        $("#cep").removeClass("is-invalid");

                        $("form").append(
                            `<div class="endereco">

                            <div class="row g-3">
                            <div class="col-sm-8">
                            <div class="form-floating">
                            <input type="text" class="form-control" id="logradouro" name="logradouro" value=" ` + data
                            .logradouro + ` " readonly>
                            <label for="logradouro">Logradouro*</label>
                            </div>
                            </div>

                            <div class="col-sm">
                            <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="numero" name="numero" placeholder="numero">
                            <label for="numero">Numero*</label>
                            </div>
                            </div>
                            </div>

                            <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="complemento" name="complemento" value=" ` +
                            data
                            .complemento + ` " placeholder="complemento">
                            <label for="complemento">Complemento</label>
                            </div>

                            <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="bairro" name="bairro" value=" ` + data
                            .bairro + ` "readonly>
                            <label for="bairro">Bairro*</label>
                            </div>

                            <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="cidade" name="cidade" value=" ` + data
                            .localidade + ` "readonly>
                            <label for="cidade">Cidade*</label>
                            </div>

                            <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="estado" name="estado" value=" ` + data
                            .uf + ` "readonly>
                            <label for="estado">Estado*</label>
                            </div>
                           
                            <input class="btn btn-primary" type="submit" id="salvar" value="Enviar">
                            </div>
                     
                            `);

                    } else {
                        //aqui ele mostra os erros que colocamos no backend
                        $("#cep").addClass("is-invalid");
                        $("#validaCEP").html(data.erro);

                    }

                },
                //aqui ele retorna erro caso tente burlar as verificaçoes do front, passando pela validação do backend
                error: function(xhr) {
                    $("#cep").addClass("is-invalid");
                    var blkstr = [];
                    var data = xhr.responseJSON;
                    if ($.isEmptyObject(data.errors) == false) {
                        $.each(data.errors, function(key, value) {
                            var str = value;
                            blkstr.push(str);
                        });
                        $("#validaCEP").html(blkstr.join("<br>"));

                    }

                },
            });

        }




        //ajax criar pedido

        $('form[name="form-cadastrar-pedido"]').on("submit", function(event) {
            event.preventDefault();
            var cep = $("#cep").val().replace(/\D/g, '');
            var dados = $(this).serialize();

            dados += "&cep=" + cep;

            $.ajax({
                url: '{{ route('salvar') }}',
                type: "post",
                data: dados,
                dataType: "json",

                beforeSend: function() {
                    $(".load").removeClass("d-none");
                    $("#salvar").attr("disabled", true);
                },
                complete: function() {
                    $(".load").addClass("d-none");
                },

                success: function(data) {
                    if (!("erro" in data)) {
                        $('form[name="form-cadastrar-pedido"]').trigger("reset");
                        $(".endereco").remove();
                        $(".messageBox").removeClass("d-none").html(data.message);
                        setTimeout(function() {
                            $(".messageBox").addClass("d-none");
                        }, 5000);
                    } else {
                        $(".messageBoxError").removeClass("d-none").html(data.erro);
                        setTimeout(function() {
                            $(".messageBoxError").addClass("d-none");
                        }, 3000);
                    }
                    $("#salvar").attr("disabled", false);
                },
                error: function(xhr) {
                    $(".messageBox").addClass("d-none");
                    var blkstr = [];
                    var data = xhr.responseJSON;
                    if ($.isEmptyObject(data.errors) == false) {
                        $.each(data.errors, function(key, value) {
                            var str = value;
                            blkstr.push(str);
                        });
                        $(".messageBoxError")
                            .removeClass("d-none")
                            .html(blkstr.join("<br>"));
                        setTimeout(function() {
                            $(".messageBoxError").addClass("d-none");
                        }, 3000);
                    }
                    $("#salvar").attr("disabled", false);
                },
            });
        });

    </script>
</body>

</html>
