<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="./crud_entrega_entregador.css">
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
                        <a class="nav-link navbar-text " href="../admin_entregador/admin_entregador.php">Consultar Entregas</a>
                    </li>
                </ul>
            </div>

            <div class="col-4 ">
                <ul class="navbar-nav align-items-center justify-content-end" style="height: 100%;">
                    <li class="nav-item mx-5">
                        <a class="nav-link navbar-text" href="#"> <span style="color: grey; font-weight: 500;">Olá, </span><b>Entregador</b></a>
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
            <?php
            //$idEncomenda = isset($_COOKIE['idEncomenda']) ? $_COOKIE['idEncomenda'] : null;
            $idEncomenda = 3;
            if ($idEncomenda) {
                $server = "localhost";
                $usuario = "root";
                $senha = "";
                $banco = "lojaentregas";

                try {
                    $dsn = "mysql:host=$server;dbname=$banco;charset=utf8mb4";
                    $options = [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ];

                    $pdo = new PDO($dsn, $usuario, $senha, $options);
                } catch (PDOException $e) {
                    die('Connection failed: ' . $e->getMessage());
                }
                    
                $query = "SELECT * FROM ENCOMENDA WHERE ID_ENCOMENDA = :idEncomenda";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':idEncomenda', $idEncomenda);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    $id = $row['ID_ENCOMENDA'];
                    $peso = $row['PESO'];
                    $altura = $row['ALTURA'];
                    $largura = $row['LARGURA'];
                    $profundidade = $row['PROFUNDIDADE'];
                    $data_prevista = $row['DATA_PREVISTA'];
                    $observacao = $row['OBSERVACAO'];
                    $idEntregador = $row['ID_ENTREGADOR'];
                    $idLoja = $row['ID_LOJA'];
                    $idDestinatario = $row['ID_DESTINATARIO'];
                    $idStatus = $row['ID_STATUS'];

                    $query = "SELECT * FROM ENTREGADOR WHERE ID_ENTREGADOR = :idEntregador";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':idEntregador', $idEntregador);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        $entregador = $row['NOME'];
                        $value = $row['CPF'];
                        $entregadorCPF = substr($value, 0, 3) . '.' . substr($value, 3, 3) . '.' . substr($value, 6, 3) . '-' . substr($value, 9, 2);
                    }

                    $query = "SELECT * FROM LOJA WHERE ID_LOJA = :idLoja";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':idLoja', $idLoja);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        $loja = $row['RAZAO_SOCIAL'];
                        $value = $row['CNPJ'];
                        $lojaCNPJ = substr($value, 0, 2) . '.' . substr($value, 2, 3) . '.' . substr($value, 5, 3) . '/' . substr($value, 8, 4) . '-' . substr($value, 12, 2);
                    }

                    $query = "SELECT * FROM DESTINATARIO WHERE ID_DESTINATARIO = :idDestinatario";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':idDestinatario', $idDestinatario);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        $destinatario = $row['NOME'];
                        $value = $row['CPF_CNPJ'];
                        if(strlen($value) === 11)
                            $destinatarioCPFCNJP = substr($value, 0, 3) . '.' . substr($value, 3, 3) . '.' . substr($value, 6, 3) . '-' . substr($value, 9, 2);
                        else
                            $destinatarioCPFCNJP = substr($value, 0, 2) . '.' . substr($value, 2, 3) . '.' . substr($value, 5, 3) . '/' . substr($value, 8, 4) . '-' . substr($value, 12, 2);

                        $idEndereco = $row['ID_ENDERECO'];
                    }

                    $query = "SELECT * FROM STATUS WHERE ID_STATUS = :idStatus";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':idStatus', $idStatus);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        $status = $row['NOME'];
                    }

                    $query = "SELECT * FROM ENDERECO WHERE ID_ENDERECO = :idEndereco";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':idEndereco', $idEndereco);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        $cep = $row['CEP'];
                        $numero = $row['NUMERO'];
                        $logradouro = $row['LOGRADOURO'];
                        $bairro = $row['BAIRRO'];
                        $complemento = $row['COMPLEMENTO'];
                        $cidade = $row['CIDADE'];
                        $uf = $row['UF'];
                    }
                }
            }
            ?>
            <form name="Cadastro" action="crud_entrega_entregador_utils.php" method="POST">
                <div class="col-md-12">
                    <div class="row align-items-center">
                        <div class="text-center header-text mb-4">
                            <h3>Encomenda</h3>
                        </div>
                        <?php
                        if (isset($_GET['error'])) {
                            $errorMessage = urldecode($_GET['error']);
                            echo '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>';
                        } elseif (isset($_GET['success'])) {
                            echo '<div class="alert alert-success" role="alert">Cadastrado com sucesso.</div>';
                        }
                        ?>
                        <div class="row">
                            <div class="col-4  mb-3">
                                <input name = "id" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Nº" value=<?php echo isset($id) ? $id : ''; ?>>
                            </div>
                            <div class="col-2 mb-3">
                                <input name = "peso" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Peso" value=<?php echo isset($peso) ? $peso : ''; ?>>
                            </div>
                            <div class="col-2 mb-3">
                                <input name = "altura" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Altura" value=<?php echo isset($altura) ? $altura : ''; ?>>
                            </div>
                            <div class="col-2 mb-3">
                                <input name="largura" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Largura" value=<?php echo isset($largura) ? $largura : ''; ?>>
                            </div>
                            <div class="col-2 mb-3">
                                <input name="profundidade" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Profundidade" value=<?php echo isset($profundidade) ? $profundidade : ''; ?>>
                            </div>
                            <div class="col-4 mb-3">
                                <select name="status" class="form-select form-select-lg bg-light fs-6">
                                    <option selected disabled hidden>Status</option>
                                </select>
                            </div>
                            <div class="col-4 mb-3">
                                <input name="observacao" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Observação" value=<?php echo isset($observacao) ? $observacao : ''; ?>>
                            </div>
                            <div class="col-4 mb-3">
                                <input name="dataPrevista" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Data Prevista" value=<?php echo isset($data_prevista) ? $data_prevista : ''; ?>>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 mb-3">
                                <input id="login-cpf-cnpj" name='cpf_entregador' type="text" class="form-control form-control-lg bg-light fs-6" placeholder="CPF" onblur="formatInputNumber()"
                                value=<?php echo isset($entregadorCPF) ? $entregadorCPF : ''; ?>>
                            </div>
                            <div class="col-9  mb-3">
                                <input name="entregador" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Entregador" value=<?php echo isset($entregador) ? $entregador : ''; ?>>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 mb-3">
                                <input id="login-cpf-cnpj" name="cnpj_loja" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="CPF" onblur="formatInputNumber()" value=<?php echo isset($lojaCNPJ) ? $lojaCNPJ : ''; ?>>
                            </div>
                            <div class="col-9  mb-3">
                                <input type="text" name="loja"class="form-control form-control-lg bg-light fs-6" placeholder="Loja" value=<?php echo isset($loja) ? $loja : ''; ?>>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 mb-3">
                                <input id="login-cpf-cnpj" name="cpf_destinatario" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="CPF/CNPJ" onblur="formatInputNumber()" 
                                value=<?php echo isset($destinatarioCPFCNJP) ? $destinatarioCPFCNJP : ''; ?>>
                            </div>
                            <div class="col-9  mb-3">
                                <input name="destinatario" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Destinatário" value=<?php echo isset($destinatario) ? $destinatario : ''; ?>>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 mb-3">
                                <input id="cadastro-cep" name='cep' type="text" class="form-control form-control-lg bg-light fs-6" placeholder="CEP" onblur="atualizaCampos()"
                                value=<?php echo isset($cep) ? $cep : ''; ?>>
                            </div>
                            <div class="col-3 mb-3">
                                <input type="text" name="numero" class="form-control form-control-lg bg-light fs-6" placeholder="Numero"
                                value=<?php echo isset($numero) ? $numero : ''; ?>>
                            </div>
                            <div class="col-6 mb-3">
                                <input id="cadastro-logradouro" name="logradouro" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Logradouro"
                                value=<?php echo isset($logradouro) ? $logradouro : ''; ?>>
                            </div>
                            <div class="col-6 mb-3">
                                <input id="cadastro-bairro" name="bairro" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Bairro"
                                value=<?php echo isset($bairro) ? $bairro : ''; ?>>
                            </div>
                            <div class="col-3 mb-3">
                                <input id="cadastro-cidade" name="cidade" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Cidade"
                                value=<?php echo isset($cidade) ? $cidade : ''; ?>>
                            </div>
                            <div class="col-3 mb-3">
                                <input id="cadastro-uf" name="uf"type="text" class="form-control form-control-lg bg-light fs-6" placeholder="UF"
                                value=<?php echo isset($uf) ? $uf : ''; ?>>
                            </div>
                            <div class="input-group mb-3">
                                <input id="cadastro-complemento" name="complemento" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Complemento"
                                value=<?php echo isset($complemento) ? $complemento : ''; ?>>
                            </div>
                        </div>

                        <div class="row col-12 justify-content-center">
                            <div class="col-4">
                                <button disabled type="submit" name="action" id="confirmar-button" class="btn btn-lg btn-success w-100 fs-6" value="update">Confirmar</button>
                            </div>
                            <div class="col-4">
                                <button type="button" id="alterar-button" class="btn btn-lg btn-warning w-100 fs-6">Alterar</button>
                            </div>
                            <div class="col-4">
                                <button type="submit" name="action" class="btn btn-lg btn-danger w-100 fs-6" value="delete">Excluir</button>
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