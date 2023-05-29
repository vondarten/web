<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $peso = $_POST['peso'];
    $altura = $_POST['altura'];
    $largura = $_POST['largura'];
    $profundidade = $_POST['profundidade'];
    $observacao = $_POST['observacao'];
    $destinatario = $_POST['destinatario'];
    $destinatarioCPFCNPJ = $_POST['destinatarioCPFCNPJ'];
    $entregador = $_POST['entregador'];
    $entregadorCPF = $_POST['entregadorCPF'];
    $loja = $_POST['loja'];
    
    $data = '10/01/2023';
    $status = 1;
    $id_transportadora = 1;
    $cep = $_POST['cep'];
    $numero = $_POST['numero'];
    $logradouro = $_POST['logradouro'];
    $bairro = $_POST['bairro'];
    $complemento = $_POST['complemento'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];

    if($peso===NULL) {
        $message = 'Error: Preencha todos os campos.';
        echo '<script> window.location.href = "crud_entrega_criar.php?error=' . urlencode($message) . '"; </script>'; 
    }

    if (!$peso || !$altura || !$largura || !$profundidade|| !$status || !$observacao || !$destinatario || !$destinatarioCPFCNPJ || !$entregador || !$entregadorCPF || !$loja || !$id_transportadora || !$cep || !$numero || !$logradouro || !$bairro || !$cidade || !$uf) {
        $message = 'Error: Preencha todos os campos.';
        echo '<script> window.location.href = "crud_entrega_criar.php?error=' . urlencode($message) . '"; </script>';
    } else {
        $dbHost = 'localhost';
        $dbUser = 'root';
        $dbPass = '';
        $dbName = 'lojaentregas';

        $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

        if ($conn->connect_error) {
            $message = 'Error: Erro ao Cadastrar.';
            echo '<script> window.location.href = "crud_entrega_criar.php?error=' . urlencode($message) . '"; </script>';
        }

        $valEnd = $conn->prepare("SELECT `ID_ENDERECO` FROM `ENDERECO` WHERE CEP = ? AND NUMERO = ?");
        $valEnd->bind_param('ss', $cep, $numero);
        $valEnd->execute();
        $resultVal = $valEnd->get_result();

        if (!$resultVal) {
            $message = 'Error: Erro ao Cadastrar.';
            echo '<script> window.location.href = "crud_entrega_criar.php?error=' . urlencode($message) . '"; </script>';
        }

        $valEnd->close();

        $row = $resultVal->fetch_assoc();
        if ($row == null) {
            $stmt = $conn->prepare('INSERT INTO ENDERECO (CEP, NUMERO, LOGRADOURO, BAIRRO, COMPLEMENTO, CIDADE, UF) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->bind_param('sisssss', $cep, $numero, $logradouro, $bairro, $complemento, $cidade, $uf);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
            } else {
                $message = 'Error: Erro ao Cadastrar.';
                echo '<script> window.location.href = "crud_entrega_criar.php?error=' . urlencode($message) . '"; </script>';
            }

            $stmt->close();

            $getIDEnd = $conn->prepare("SELECT `ID_ENDERECO` FROM `ENDERECO` WHERE CEP = ? AND NUMERO = ?");
            $getIDEnd->bind_param('ss', $cep, $numero);
            $getIDEnd->execute();
            $result = $getIDEnd->get_result();

            $getIDEnd->close();

            if (!$result) {
                $message = 'Error: Erro ao Cadastrar.';
                echo '<script> window.location.href = "crud_entrega_criar.php?error=' . urlencode($message) . '"; </script>';
            }

            $row = $result->fetch_assoc();
            $idEndereco = $row['ID_ENDERECO'];
        } else {
            $idEndereco = $row['ID_ENDERECO'];
        }


        $valEntregador = $conn->prepare("SELECT `ID_ENTREGADOR` FROM `ENTREGADOR` WHERE CPF = ?");
        $valEntregador->bind_param('s', $cpf);
        $valEntregador->execute();
        $resultValL = $valEntregador->get_result();

        if (!$resultVal) {
            $message = 'Error: Erro ao Cadastrar.';
            echo '<script> window.location.href = "crud_entrega_criar.php?error=' . urlencode($message) . '"; </script>';
        }

        $rowL = $resultValL->fetch_assoc();
        if ($rowL == null) {
            $stmt = $conn->prepare('INSERT INTO ENCOMENDA (PESO, ALTURA, LARGURA, PROFUNDIDADE, DATA_PREVISTA, OBSERVACAO, ID_ENTREGADOR, ID_LOJA, ID_DESTINATARIO, ID_STATUS) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->bind_param('ddddssiiis', $peso, $altura, $largura, $profundidade, $data, $observacao, $entregador, $loja, $destinatario, $status);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo '<script> window.location.href = "crud_entrega_criar.php?success"; </script>';
            } else {
                $message = 'Error: Erro ao Cadastrar.';
                echo '<script> window.location.href = "crud_entrega_criar.php?error=' . urlencode($message) . '"; </script>';
            }

            $stmt->close();
        } else {
            $message = 'Error: Entregador já Cadastrada.';
            echo '<script> window.location.href = "crud_entrega_criar.php?error=' . urlencode($message) . '"; </script>';
        }

        $conn->close();
        
    }
}
