<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="./crud_entrega.css">
    <script src="./crud_entrega.js"></script>
    <script src="../shared/consulta_logradouro.js"></script>

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

            <form name="Cadastro" action="./crud_entrega_criar_utils.php" method="POST">
                <div class="col-md-12">
                    <div class="row align-items-center">
                        <div class="text-center header-text mb-4">
                            <h3>Encomenda</h3>
                        </div>
                        <div id="alert">
                        <?php
                        // Check for error or success messages in the URL query parameters
                        if (isset($_GET['error'])) {
                            $errorMessage = urldecode($_GET['error']);
                            echo '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>';
                        } elseif (isset($_GET['success'])) {
                            echo '<div class="alert alert-success" role="alert">Cadastrado com sucesso.</div>';
                        }
                        ?>
                        </div>
                        <div class="row">
                            <div class="col-4  mb-3">
                                <input name="id" id="order-n" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Nº" value=<?php echo isset($id) ? $id : ''; ?>>
                            </div>
                            <div class="col-2 mb-3">
                                <input name="peso" id="order-peso" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Peso" value=<?php echo isset($peso) ? $peso : ''; ?>>
                            </div>
                            <div class="col-2 mb-3">
                                <input name="altura" id="order-altura" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Altura" value=<?php echo isset($altura) ? $altura : ''; ?>>
                            </div>
                            <div class="col-2 mb-3">
                                <input name="largura" id="order-largura" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Largura" value=<?php echo isset($largura) ? $largura : ''; ?>>
                            </div>
                            <div class="col-2 mb-3">
                                <input name="profundidade" id="order-profundidade" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Profundidade" value=<?php echo isset($profundidade) ? $profundidade : ''; ?>>
                            </div>
                            <div class="col-4" mb-3>
                                <select class="form-select form-select-lg bg-light fs-6">
                                    <option name="status" selected hidden>Status</option>
                                </select>
                            </div>
                            <div class="col-8 mb-3">
                                <input name="observacao" id="order-observacao" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Observação" value=<?php echo isset($observacao) ? $observacao : ''; ?>>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-9  mb-3">
                                <input name="destinatario" id="order-destinatario" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Destinatário" value=<?php echo isset($destinatario) ? $destinatario : ''; ?>>
                            </div>
                            <div class="col-3 mb-3">
                                <input name="destinatarioCPFCNPJ" id="login-cpf-cnpj-dest" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="CPF/CNPJ" onblur="formatInputNumber('login-cpf-cnpj-dest')" value=<?php echo isset($destinatarioCPFCNJP) ? $destinatarioCPFCNJP : ''; ?>>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 mb-3">
                                <input name="cep" id="cadastro-cep" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="CEP" onblur="atualizaCampos() value=<?php echo isset($cep) ? $cep : ''; ?>">
                            </div>
                            <div class="col-3 mb-3">
                                <input name="numero" id="cadastro-numero" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Numero" value=<?php echo isset($numero) ? $numero : ''; ?>>
                            </div>
                            <div class="col-6 mb-3">
                                <input name="logradouro" id="cadastro-logradouro" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Logradouro" value=<?php echo isset($logradouro) ? $logradouro : ''; ?>>
                            </div>
                            <div class="col-6 mb-3">
                                <input name="bairro" id="cadastro-bairro" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Bairro" value=<?php echo isset($bairro) ? $bairro : ''; ?>>
                            </div>
                            <div class="col-3 mb-3">
                                <input name="cidade" id="cadastro-cidade" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Cidade" value=<?php echo isset($cidade) ? $cidade : ''; ?>>
                            </div>
                            <div class="col-3 mb-3">
                                <input name="uf" id="cadastro-uf" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="UF" value=<?php echo isset($uf) ? $uf : ''; ?>>
                            </div>
                            <div class="input-group mb-3">
                                <input name="complemento" id="cadastro-complemento" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Complemento" value=<?php echo isset($complemento) ? $complemento : ''; ?>>
                            </div>
                        </div>

                        <div class="row col-12 justify-content-center">

                            <div class="col-4">
                                <button class="btn btn-lg btn-success w-100 fs-6" onclick="window.location.pathname = 'www/web/admin_loja/admin_loja.php'">Cadastrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function formatNumber(number) {
            const cleanedNumber = number.replace(/\D/g, '');

            const isCpf = cleanedNumber.length === 11;

            const mask = isCpf ? '000.000.000-00' : '00.000.000/0000-00';

            let formattedNumber = '';
            let index = 0;
            for (let i = 0; i < mask.length; i++) {
                if (mask[i] === '0') {
                    formattedNumber += cleanedNumber[index] || '';
                    index++;
                } else {
                    formattedNumber += mask[i];
                }
            }

            return formattedNumber;
        }

        function formatInputNumber(id) {
            const numberInput = document.getElementById(id);
            const inputValue = numberInput.value;

            const formattedNumber = formatNumber(inputValue);
            numberInput.value = formattedNumber;
        }


        const orderN = document.getElementById('order-n');
        const orderPeso = document.getElementById('order-peso');
        const orderAltura = document.getElementById('order-altura');

        const orderLargura = document.getElementById('order-largura');
        const orderProfundidade = document.getElementById('order-profundidade');
        const orderObservacao = document.getElementById('order-observacao');
        const orderDestinatario = document.getElementById('order-destinatario');
        // 3 iguais
        const orderCPF_CNPJ_Dest = document.getElementById('login-cpf-cnpj-dest');
        const orderCPF_CNPJ_Entregador = document.getElementById('login-cpf-cnpj-entregador');
        const orderCPF_CNPJ_Loja = document.getElementById('login-cpf-cnpj-loja');
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
           confirmarButton.disabled = !confirmarButton.disabled
        })

        alterarButton.addEventListener('click', function() {
            confirmarButton.disabled = !confirmarButton.disabled
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

            orderCPF_CNPJ_Dest.disabled = !orderCPF_CNPJ_Dest.disabled;
            orderCPF_CNPJ_Entregador.disabled = !orderCPF_CNPJ_Entregador.disabled;
            orderCPF_CNPJ_Loja.disabled = !orderCPF_CNPJ_Loja.disabled;

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