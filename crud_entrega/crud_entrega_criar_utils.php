<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if(isset($_COOKIE['idLoja'])){
        $idLoja = $_COOKIE['idLoja'];
    } 
    
    $peso = $_POST['peso'];
    $altura = $_POST['altura'];
    $largura = $_POST['largura'];
    $profundidade = $_POST['profundidade'];
    $idStatus = $_POST['status'];
    $observacao = $_POST['observacao'];
    $dataPrevista = $_POST['data_prevista'];
    $destinatario = $_POST['destinatario'];
    $string = $_POST['destinatarioCPFCNPJ'];
    $destinatarioCPFCNPJ = str_replace(array('.', '/', '-'), '', $string);
    
    $data = '10/01/2023';
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

    if (!$peso || !$altura || !$largura || !$profundidade|| !$idStatus || !$observacao || !$dataPrevista ||!$destinatario || !$destinatarioCPFCNPJ || !$idLoja || !$id_transportadora || !$cep || !$numero || !$logradouro || !$bairro || !$cidade || !$uf) {
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

        $valDest = $conn->prepare("SELECT `ID_DESTINATARIO` FROM `DESTINATARIO` WHERE CPF_CNPJ = ?");
        $valDest->bind_param('s', $destinatarioCPFCNPJ);
        $valDest->execute();
        $resultDest = $valDest->get_result();

        if (!$valDest) {
            $message = 'Error: Erro ao Cadastrar.';
            echo '<script> window.location.href = "crud_entrega_criar.php?error=' . urlencode($message) . '"; </script>';
        }

        $valDest->close();

        $row = $resultDest->fetch_assoc();
        if ($row == null) {
            $stmt = $conn->prepare('INSERT INTO DESTINATARIO (NOME,CPF_CNPJ,ID_ENDERECO) VALUES (?, ?, ?)');
            $stmt->bind_param('ssi', $destinatario, $destinatarioCPFCNPJ, $idEndereco);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
            } else {
                $message = 'Error: Erro ao Cadastrar.';
                echo '<script> window.location.href = "crud_entrega_criar.php?error=' . urlencode($message) . '"; </script>';
            }

            $stmt->close();

            $valDest = $conn->prepare("SELECT `ID_DESTINATARIO` FROM `DESTINATARIO` WHERE CPF_CNPJ = ?");
            $valDest->bind_param('s', $destinatarioCPFCNPJ);
            $valDest->execute();
            $resultDest = $valDest->get_result();

            $valDest->close();

            if (!$resultDest) {
                $message = 'Error: Erro ao Encontrar Destinatario.';
                echo '<script> window.location.href = "crud_entrega_criar.php?error=' . urlencode($message) . '"; </script>';
            }

            $row = $resultDest->fetch_assoc();
            $idDestinatario = $row['ID_DESTINATARIO'];
        } else {
            $idDestinatario = $row['ID_DESTINATARIO'];
        }

        $getEnt = $conn->prepare("SELECT `ID_ENTREGADOR` FROM `ENTREGADOR`");
        $getEnt->execute();
        $resultEnt = $getEnt->get_result();

        $rows = $resultEnt->fetch_all(MYSQLI_ASSOC);

        shuffle($rows);

        $randomResult = null;
        if (!empty($rows)) {
            $idEntregador = $rows[0]['ID_ENTREGADOR'];
        }

        $getEnt->close();

        $rowEnt = $resultEnt->fetch_assoc();

        $stmt = $conn->prepare('INSERT INTO ENCOMENDA (PESO, ALTURA, LARGURA, PROFUNDIDADE, DATA_PREVISTA, OBSERVACAO, ID_ENTREGADOR, ID_LOJA, ID_DESTINATARIO, ID_STATUS) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('ddddssiiii', $peso, $altura, $largura, $profundidade, $dataPrevista, $observacao, $idEntregador, $idLoja, $idDestinatario, $idStatus);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo '<script> window.location.href = "crud_entrega_criar.php?success"; </script>';
        } else {
            $tmp = $stmt->error;
            $message = "Error: Erro ao Cadastrar. $tmp $idDestinatario";
            echo '<script> window.location.href = "crud_entrega_criar.php?error=' . urlencode($message) . '"; </script>';
        }

        $stmt->close();
        $conn->close();
        
    }
}
