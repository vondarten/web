<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $razaoSocial = $_POST['razao-social'];
    $cnpj = $_POST['cnpj'];
    $cep = $_POST['cep'];
    $numero = $_POST['numero'];
    $logradouro = $_POST['logradouro'];
    $bairro = $_POST['bairro'];
    $complemento = $_POST['complemento'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];
    $senha = $_POST['senha'];
    $senhaConf = $_POST['senha-conf'];

    if ($senha !== $senhaConf) {
        die('Error: Senha and Senha Confirm do not match.');
    }

    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = '';
    $dbName = 'lojaentregas';

    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $valEnd = $conn->prepare("SELECT `ID_ENDERECO` FROM `ENDERECO` WHERE CEP = ? AND NUMERO = ?");
    $valEnd->bind_param('ss', $cep, $numero);
    $valEnd->execute();
    $resultVal = $valEnd->get_result();

    if (!$resultVal) {
        die('Query failed: ' . $conn->error);
    }

    $valEnd->close();

    $row = $resultVal->fetch_assoc();
    if($row == null){
        $stmt = $conn->prepare('INSERT INTO ENDERECO (CEP, NUMERO, LOGRADOURO, BAIRRO, COMPLEMENTO, CIDADE, UF) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('iisssss',$cep, $numero, $logradouro, $bairro, $complemento, $cidade, $uf);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            echo 'Data inserted successfully.';
        } else {
            echo 'Error: Unable to insert data.';
        }
        
        $stmt->close();
    
        $getIDEnd = $conn->prepare("SELECT `ID_ENDERECO` FROM `ENDERECO` WHERE CEP = ? AND NUMERO = ?");
        $getIDEnd->bind_param('ss', $cep, $numero);
        $getIDEnd->execute();
        $result = $getIDEnd->get_result();

        $getIDEnd->close();
    
        if (!$result) {
            die('Query failed: ' . $conn->error);
        }
    
        $row = $result->fetch_assoc();
        $idEndereco = $row['ID_ENDERECO'];
    }
    else{
        $idEndereco = $row['ID_ENDERECO'];
    }

    $valLoja = $conn->prepare("SELECT `ID_LOJA` FROM `LOJA` WHERE CNPJ = ?");
    $valLoja->bind_param('s', $cnpj);
    $valLoja->execute();
    $resultValL = $valLoja->get_result();

    if (!$resultVal) {
        die('Query failed: ' . $conn->error);
    }

    $rowL = $resultValL->fetch_assoc();
    if($rowL == null){
        $stmt = $conn->prepare('INSERT INTO LOJA (RAZAO_SOCIAL, CNPJ, ID_ENDERECO) VALUES (?, ?, ?)');
        $stmt->bind_param('ssi', $razaoSocial, $cnpj, $idEndereco);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            echo 'Data inserted successfully.';
        } else {
            echo 'Error: Unable to insert data.';
        }
        
        $stmt->close();
    }
    else{
        die('Usuário já cadastrado');
    }

    $conn->close();
}
?>