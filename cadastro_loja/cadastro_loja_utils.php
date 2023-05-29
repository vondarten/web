<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $razaoSocial = $_POST['razao-social'];
    $string = $_POST['cnpj'];
    $cnpj = str_replace(array('.', '/', '-'), '', $string);
    $stringCep = $_POST['cep'];
    $cep = str_replace(array('.', '/', '-'), '', $stringCep);
    $numero = $_POST['numero'];
    $logradouro = $_POST['logradouro'];
    $bairro = $_POST['bairro'];
    $complemento = $_POST['complemento'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];
    $senha = $_POST['senha'];
    $senhaConf = $_POST['senha-conf'];

    if (!$razaoSocial || !$cnpj || !$cep || !$numero || !$logradouro || !$bairro || !$cidade || !$uf || !$senha || !$senhaConf) {
        $message = 'Error: Preencha todos os campos.';
        echo '<script> window.location.href = "cadastro_loja.php?error=' . urlencode($message) . '"; </script>';
    } else {
        if ($senha !== $senhaConf) {
            $message = 'Error: Senha e Confirmar Senha são diferentes.';
            echo '<script> window.location.href = "cadastro_loja.php?error=' . urlencode($message) . '"; </script>';
        } else {

            $dbHost = 'localhost';
            $dbUser = 'root';
            $dbPass = '';
            $dbName = 'lojaentregas';

            $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

            if ($conn->connect_error) {
                $message = 'Error: Erro ao Cadastrar.';
                echo '<script> window.location.href = "cadastro_loja.php?error=' . urlencode($message) . '"; </script>';
            }

            $valEnd = $conn->prepare("SELECT `ID_ENDERECO` FROM `ENDERECO` WHERE CEP = ? AND NUMERO = ?");
            $valEnd->bind_param('ss', $cep, $numero);
            $valEnd->execute();
            $resultVal = $valEnd->get_result();

            if (!$resultVal) {
                $message = 'Error: Erro ao Cadastrar.';
                echo '<script> window.location.href = "cadastro_loja.php?error=' . urlencode($message) . '"; </script>';
            }

            $valEnd->close();

            $row = $resultVal->fetch_assoc();
            if ($row == null) {
                $stmt = $conn->prepare('INSERT INTO ENDERECO (CEP, NUMERO, LOGRADOURO, BAIRRO, COMPLEMENTO, CIDADE, UF) VALUES (?, ?, ?, ?, ?, ?, ?)');
                $stmt->bind_param('iisssss', $cep, $numero, $logradouro, $bairro, $complemento, $cidade, $uf);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                } else {
                    $message = 'Error: Erro ao Cadastrar.';
                    echo '<script> window.location.href = "cadastro_loja.php?error=' . urlencode($message) . '"; </script>';
                }

                $stmt->close();

                $getIDEnd = $conn->prepare("SELECT `ID_ENDERECO` FROM `ENDERECO` WHERE CEP = ? AND NUMERO = ?");
                $getIDEnd->bind_param('ss', $cep, $numero);
                $getIDEnd->execute();
                $result = $getIDEnd->get_result();

                $getIDEnd->close();

                if (!$result) {
                    $message = 'Error: Erro ao Cadastrar.';
                    echo '<script> window.location.href = "cadastro_loja.php?error=' . urlencode($message) . '"; </script>';
                }

                $row = $result->fetch_assoc();
                $idEndereco = $row['ID_ENDERECO'];
            } else {
                $idEndereco = $row['ID_ENDERECO'];
            }

            $valLoja = $conn->prepare("SELECT `ID_LOJA` FROM `LOJA` WHERE CNPJ = ?");
            $valLoja->bind_param('s', $cnpj);
            $valLoja->execute();
            $resultValL = $valLoja->get_result();

            if (!$resultVal) {
                $message = 'Error: Erro ao Cadastrar.';
                echo '<script> window.location.href = "cadastro_loja.php?error=' . urlencode($message) . '"; </script>';
            }

            $rowL = $resultValL->fetch_assoc();
            if ($rowL == null) {
                $stmt = $conn->prepare('INSERT INTO LOJA (RAZAO_SOCIAL, CNPJ, SENHA, ID_ENDERECO) VALUES (?, ?, ?, ?)');
                $stmt->bind_param('sssi', $razaoSocial, $cnpj, $senha, $idEndereco);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    echo '<script> window.location.pathname = "www/web/login/login.php"; </script>';
                } else {
                    $message = 'Error: Erro ao Cadastrar.';
                    echo '<script> window.location.href = "cadastro_loja.php?error=' . urlencode($message) . '"; </script>';
                }

                $stmt->close();
            } else {
                $message = 'Error: Loja já Cadastrada.';
                echo '<script> window.location.href = "cadastro_loja.php?error=' . urlencode($message) . '"; </script>';
            }

            $conn->close();
        }
    }
}
