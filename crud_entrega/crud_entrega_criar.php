<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="./crud_entrega.css">
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
                                <input disabled name="id" id="order-n" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Nº">
                            </div>
                            <div class="col-2 mb-3">
                                <input name="peso" id="order-peso" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Peso">
                            </div>
                            <div class="col-2 mb-3">
                                <input name="altura" id="order-altura" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Altura">
                            </div>
                            <div class="col-2 mb-3">
                                <input name="largura" id="order-largura" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Largura">
                            </div>
                            <div class="col-2 mb-3">
                                <input name="profundidade" id="order-profundidade" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Profundidade">
                            </div>
                            <div class="col-4" mb-3>
                                <select name="status" class="form-select form-select-lg bg-light fs-6">
                                <option disabled selected hidden>Status</option>
                                    <?php
                                    $dbHost = 'localhost';
                                    $dbUser = 'root';
                                    $dbPass = '';
                                    $dbName = 'lojaentregas';

                                    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

                                    $result = $conn->query("SELECT * FROM STATUS");
                                    if (!$result) {
                                        $message = 'Error: Erro ao Listas Status.';
                                        echo '<script> window.location.href = "cadastro_colaborador.php?error=' . urlencode($message) . '"; </script>';
                                    };

                                    while ($row = $result->fetch_assoc()) {
                                        $value = $row['ID_STATUS'];
                                        $name = $row['NOME'];
                                        if ($value == $idStatus)
                                            echo "<option selected value=$value> $name</option>";
                                        else
                                            echo "<option value=$value> $name</option>";
                                    }

                                    ?>
                                </select>
                            </div>
                            <div class="col-4 mb-3">
                                <input name="observacao" id="order-observacao" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Observação">
                            </div>
                            <div class="col-4 mb-3">
                                <input id="data-prevista" name="data_prevista" type="date" class="form-control form-control-lg bg-light fs-6" placeholder="Data Prevista" onblur="formatInputData('data-prevista')">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-9  mb-3">
                                <input name="destinatario" id="order-destinatario" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Destinatário">
                            </div>
                            <div class="col-3 mb-3">
                                <input name="destinatarioCPFCNPJ" id="login-cpf-cnpj-dest" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="CPF/CNPJ" onblur="formatInputNumber('login-cpf-cnpj-dest')">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 mb-3">
                                <input name="cep" id="cadastro-cep" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="CEP" onblur="atualizaCampos();formatCEP('cadastro-cep')">
                            </div>
                            <div class="col-3 mb-3">
                                <input name="numero" id="cadastro-numero" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Numero">
                            </div>
                            <div class="col-6 mb-3">
                                <input name="logradouro" id="cadastro-logradouro" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Logradouro">
                            </div>
                            <div class="col-6 mb-3">
                                <input name="bairro" id="cadastro-bairro" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Bairro">
                            </div>
                            <div class="col-3 mb-3">
                                <input name="cidade" id="cadastro-cidade" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Cidade">
                            </div>
                            <div class="col-3 mb-3">
                                <input name="uf" id="cadastro-uf" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="UF">
                            </div>
                            <div class="input-group mb-3">
                                <input name="complemento" id="cadastro-complemento" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Complemento">
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
                function returnCEPformated(number){
            const cleanedNumber = number.replace(/\D/g, '');
            const mask = '00.000-000';

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
        function formatCEP(id) {
            const numberInput = document.getElementById(id);
            const inputValue = numberInput.value;

            const formattedNumber = returnCEPformated(inputValue);
            numberInput.value = formattedNumber;
        }
    </script>

</body>

</html>