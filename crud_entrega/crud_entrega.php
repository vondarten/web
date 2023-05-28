<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="./crud_entrega.css">
    <script src="./crud_entrega.js"></script>
    <script src="/shared/consulta_logradouro.js"></script>

    <title>Admin - Entrega</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-center ml-3 bg-white shadow">
        <div class="row col-12 d-flex">

            <div class="col-4">
                <a class="navbar-brand d-flex align-items-center mx-5" href="#" style="font-weight: 800 !important; color: #070f52 !important;">
                    <img src="../img/logo.png" alt="Logo" class="logo-img">
                    <b class="mr-2 navbar-text">IP Logistics</b>
                </a>
            </div>

            <div class="col-4">
                <ul class="navbar-nav align-items-center justify-content-center" style="height: 100%;">
                    <li class="nav-item mx-3">
                        <a class="nav-link navbar-text " href="../admin_loja/admin_loja.php">Consultar Entregas</a>
                    </li>
                </ul>
            </div>

            <div class="col-4 ">
                <ul class="navbar-nav align-items-center justify-content-end" style="height: 100%;">
                    <li class="nav-item mx-5">
                        <a class="nav-link navbar-text" href="#"> <span style="color: grey; font-weight: 500;">Olá, </span><b>Lojista</b></a>
                    </li>
                    <li class="nav-item mx-5">
                        <a class="nav-link navbar-text" href="../login/login.php">Sair</a>
                    </li>
                </ul>
            </div>
        </div>    
    </nav>

    <div class="container d-flex justify-content-center align-items-center min-vh-100" style="margin-top: -5%;">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">

            <div class="col-md-12">
                <div class="row align-items-center">
                    <div class="text-center header-text mb-4">
                        <h3>Encomenda</h3>
                    </div>
                    <div class="row">
                        <div class="col-4  mb-3">
                            <input disabled id="order-n" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Nº">
                        </div>
                        <div class="col-2 mb-3">
                            <input disabled id="order-peso" type="text" class="form-control form-control-lg bg-light fs-6"             placeholder="Peso">
                        </div>
                        <div class="col-2 mb-3">
                            <input disabled id="order-altura" type="text" class="form-control form-control-lg bg-light fs-6"             placeholder="Altura">
                        </div>
                        <div class="col-2 mb-3">
                            <input disabled id="order-largura" type="text" class="form-control form-control-lg bg-light fs-6"             placeholder="Largura">
                        </div>
                        <div class="col-2 mb-3">
                            <input disabled id="order-profundidade" type="text" class="form-control form-control-lg bg-light fs-6"             placeholder="Profundidade">
                        </div>
                        <div class="col-4" mb-3>
                            <select class="form-select form-select-lg bg-light fs-6" >
                                <option selected disabled hidden >Status</option>
                            </select>
                        </div>
                        <div class="col-8 mb-3">
                            <input disabled id="order-observacao" type="text" class="form-control form-control-lg bg-light fs-6"             placeholder="Observação">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-9  mb-3">
                            <input disabled id="order-destinatario" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Destinatário">
                        </div>
                        <div class="col-3 mb-3">
                            <input disabled id="login-cpf-cnpj" type="text" class="form-control form-control-lg bg-light fs-6"
                                placeholder="CPF/CNPJ" onblur="formatInputNumber()">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-9  mb-3">
                            <input disabled id="order-entregador" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Entregador">
                        </div>
                        <div class="col-3 mb-3">
                            <input disabled id="login-cpf-cnpj" type="text" class="form-control form-control-lg bg-light fs-6"
                                placeholder="CPF/CNPJ" onblur="formatInputNumber()">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-9  mb-3">
                            <input disabled id="order-loja" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Loja">
                        </div>
                        <div class="col-3 mb-3">
                            <input disabled id="login-cpf-cnpj" type="text" class="form-control form-control-lg bg-light fs-6"
                                placeholder="CPF/CNPJ" onblur="formatInputNumber()">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 mb-3">
                            <input disabled id="cadastro-cep" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="CEP" onblur="atualizaCampos()">
                        </div>
                        <div class="col-3 mb-3">
                            <input id="cadastro-numero" disabled type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Numero">
                        </div>
                        <div class="col-6 mb-3">
                            <input disabled id="cadastro-logradouro" type="text" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Logradouro">
                        </div>
                        <div class="col-6 mb-3">
                            <input disabled id="cadastro-bairro" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Bairro">
                        </div>
                        <div class="col-3 mb-3">
                            <input disabled id="cadastro-cidade" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Cidade">
                        </div>
                        <div class="col-3 mb-3">
                            <input disabled id="cadastro-uf" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="UF">
                        </div>
                        <div class="input-group mb-3">
                            <input disabled id="cadastro-complemento" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Complemento">
                        </div>
                    </div>

                    <div class="row col-12 justify-content-center">
                        
                        <div class="col-4">
                            <button id="confirmar-button" class="btn btn-lg btn-success w-100 fs-6">Nova</button>
                        </div>
                        <div class="col-4">
                            <button id="alterar-button" class="btn btn-lg btn-warning w-100 fs-6">Alterar</button>
                        </div>
                        <div class="col-4">
                            <button class="btn btn-lg btn-danger w-100 fs-6">Excluir</button>
                        </div>
                        

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>

        const orderN = document.getElementById('order-n');
        const orderPeso = document.getElementById('order-peso');
        const orderAltura = document.getElementById('order-altura');

        const orderLargura= document.getElementById('order-largura');
        const orderProfundidade = document.getElementById('order-profundidade');
        const orderObservacao = document.getElementById('order-observacao');
        const orderDestinatario = document.getElementById('order-destinatario');
        // 3 iguais
        const orderCPF_CNPJ = document.getElementById('login-cpf-cnpj');
        const orderEntregador = document.getElementById('order-entregador');
        const orderLoja = document.getElementById('order-loja');
        const orderCEP = document.getElementById('cadastro-cep');
        const orderNumero = document.getElementById('cadastro-numero');
        const orderLogradouro = document.getElementById('cadastro-logradouro');
        const orderBairro = document.getElementById('cadastro-bairro');
        const orderCidade = document.getElementById('cadastro-cidade');
        const orderUF = document.getElementById('cadastro-uf');
        const orderComplemento = document.getElementById('cadastro-complemento');

        const alterarButton = document.getElementById('alterar-button');
        const confirmarButton = document.getElementById('confirmar-button');

        

        confirmarButton.addEventListener('click', function() {
            if (confirmarButton.innerText == "Confirmar") {
                confirmarButton.innerText = "Nova"
            } else {
                confirmarButton.innerText = "Confirmar"
            } 
            invertFields()
        })

        alterarButton.addEventListener('click', function() {
            if (confirmarButton.innerText == "Confirmar") {
                confirmarButton.innerText = "Nova"
            } else {
                confirmarButton.innerText = "Confirmar"
            } 
            invertFields()
        });

        function invertFields() {
            orderN.disabled = !orderN.disabled;
            orderPeso.disabled = !orderPeso.disabled;
            orderAltura.disabled = !orderAltura.disabled;
            orderLargura.disabled = !orderLargura.disabled;
            orderProfundidade.disabled = !orderProfundidade.disabled; 
            orderObservacao.disabled = !orderObservacao.disabled;
            orderDestinatario.disabled = !orderDestinatario.disabled;
            orderCPF_CNPJ.disabled = !orderCPF_CNPJ.disabled;
            orderEntregador.disabled = !orderEntregador.disabled;
            orderLoja.disabled = !orderLoja.disabled;
            orderCEP.disabled = !orderCEP.disabled;
            orderNumero.disabled = !orderNumero.disabled;
            orderLogradouro.disabled = !orderLogradouro.disabled;
            orderBairro.disabled = !orderBairro.disabled;
            orderCidade.disabled = !orderCidade.disabled;
            orderUF.disabled = !orderUF.disabled;
            orderComplemento.disabled = !orderComplemento.disabled;
        }
    </script>

</body>
</html>