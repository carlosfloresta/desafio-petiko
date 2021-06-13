//mascara para o CEP
$("#cep").mask("99999-999");

//optei por utilizar o keyup inves do blur para ficar mais intuitivo. coloquei um time para evitar que ao colar o cep fosse feita duas ou mais requisições
$("#cep").on("keyup", function (e) {
    e.preventDefault();
    clearTimeout($(this).data("timeout"));
    var cep = $(this).val().replace(/\D/g, "");
    $(".endereco").remove();
    var validacep = /^[0-9]{8}$/;
    $(this).data(
        "timeout",
        setTimeout(function () {
            if (validacep.test(cep) && $(".endereco").length === 0) {
                ajax_cep(cep);
            } else {
                $(".endereco").remove();
            }
        }, 200)
    );
});

function ajax_cep(cep) {
    //enviando csrf com a requisição
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        type: "POST",
        dataType: "json",
        url: config.routes.busca_cep,
        data: {
            cep: cep,
        },
        beforeSend: function () {
            $(".loadcep").removeClass("d-none");
            $("#cep").attr("disabled", true);
        },
        complete: function () {
            $(".loadcep").addClass("d-none");
            $("#cep").attr("disabled", false);
        },
        //recebendo os dados do backend
        success: function (data) {
            if (!("erro" in data)) {
                $("#cep").removeClass("is-invalid");

                $("form").append(
                    `<div class="endereco">

                      <div class="row g-3">
                      <div class="col-sm-8">
                      <div class="form-floating">
                      <input type="text" class="form-control" id="logradouro" name="logradouro" value=" ` +
                        data.logradouro +
                        ` " readonly>
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
                        data.complemento +
                        ` " placeholder="complemento">
                      <label for="complemento">Complemento</label>
                      </div>

                      <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="bairro" name="bairro" value=" ` +
                        data.bairro +
                        ` "readonly>
                      <label for="bairro">Bairro*</label>
                   
                      </div>

                      <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="cidade" name="cidade" value=" ` +
                        data.localidade +
                        ` "readonly>
                      <label for="cidade">Cidade*</label>
                     
                      </div>

                      <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="estado" name="estado" value=" ` +
                        data.uf +
                        ` "readonly>
                      <label for="estado">Estado*</label>
                  
                      </div>
                     
                      <input class="btn btn-primary" type="submit" id="salvar" value="Enviar">
                      </div>
               
                      `
                );
            } else {
                //aqui ele mostra os erros que colocamos no backend
                $("#cep").addClass("is-invalid");
                $("#validaCEP").html(data.erro);
            }
        },
        //aqui ele retorna erro caso tente burlar as verificaçoes do front, passando pela validação do backend
        error: function (response) {
            $.each(response.responseJSON.errors, function (field_name, error) {
                $("#cep").addClass("is-invalid");
                $("#validaCEP").html(error);
            });
        },
    });
}

//ajax criar pedido

$('form[name="form-cadastrar-pedido"]').on("submit", function (event) {
    event.preventDefault();
    var cep = $("#cep").val().replace(/\D/g, "");
    var dados = $(this).serialize();

    dados += "&cep=" + cep;

    $.ajax({
        url: config.routes.salvar,
        type: "post",
        data: dados,
        dataType: "json",

        beforeSend: function () {
            $(".load").removeClass("d-none");
            $("#salvar").attr("disabled", true);
        },
        complete: function () {
            $(".load").addClass("d-none");
        },

        success: function (data) {
            if (!("erro" in data)) {
                $('form[name="form-cadastrar-pedido"]').trigger("reset");
                $("#nome").removeClass("is-invalid");
                $("#cep").removeClass("is-invalid");
                $(".endereco").remove();
                $(".messageBox").removeClass("d-none").html(data.message);
                setTimeout(function () {
                    $(".messageBox").addClass("d-none");
                }, 5000);
            } else {
                $(".messageBoxError").removeClass("d-none").html(data.erro);
                setTimeout(function () {
                    $(".messageBoxError").addClass("d-none");
                }, 3000);
            }
            $("#salvar").attr("disabled", false);
        },
        error: function (response) {
            $.each(response.responseJSON.errors, function (field_name, error) {
                $(document)
                    .find("[name=" + field_name + "]")
                    .removeClass("is-invalid")
                    .next(".invalid-feedback")
                    .remove();

                $(document)
                    .find("[name=" + field_name + "]")
                    .addClass("is-invalid")
                    .after(
                        '<span class="invalid-feedback">' + error + "</span>"
                    );
            });

            $("#salvar").attr("disabled", false);
        },
    });
});
