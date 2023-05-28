<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $cpf = $_POST['cpf'];
    $cat_cnh = $_POST['cat_cnh'];
    $tem_cat_a = $_POST['tem_cat_a'];
    $senha = 123456789;
    $senhaConf = 123456789;
    $id_transportadora = 1;
    $cep = $_POST['cep'];
    $numero = $_POST['numero'];
    $logradouro = $_POST['logradouro'];
    $bairro = $_POST['bairro'];
    $complemento = $_POST['complemento'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];

    if ($senha !== $senhaConf) {
        $message = 'Error: Senha e Confirmar Senha são diferentes.';
        echo '<script> window.location.href = "cadastro_colaborador.php?error='.urlencode($message).'"; </script>';
    }

    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = '';
    $dbName = 'lojaentregas';

    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($conn->connect_error) {
        $message = 'Error: Erro ao Cadastrar.';
        echo '<script> window.location.href = "cadastro_colaborador.php?error='.urlencode($message).'"; </script>';
    }

    $valEnd = $conn->prepare("SELECT `ID_ENDERECO` FROM `ENDERECO` WHERE CEP = ? AND NUMERO = ?");
    $valEnd->bind_param('ss', $cep, $numero);
    $valEnd->execute();
    $resultVal = $valEnd->get_result();

    if (!$resultVal) {
        $message = 'Error: Erro ao Cadastrar.';
        echo '<script> window.location.href = "cadastro_colaborador.php?error='.urlencode($message).'"; </script>';
    }

    $valEnd->close();

    $row = $resultVal->fetch_assoc();
    if($row == null){
        $stmt = $conn->prepare('INSERT INTO ENDERECO (CEP, NUMERO, LOGRADOURO, BAIRRO, COMPLEMENTO, CIDADE, UF) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('sisssss',$cep, $numero, $logradouro, $bairro, $complemento, $cidade, $uf);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
        } else {
            $message = 'Error: Erro ao Cadastrar.';
            echo '<script> window.location.href = "cadastro_colaborador.php?error='.urlencode($message).'"; </script>';
        }
        
        $stmt->close();
    
        $getIDEnd = $conn->prepare("SELECT `ID_ENDERECO` FROM `ENDERECO` WHERE CEP = ? AND NUMERO = ?");
        $getIDEnd->bind_param('ss', $cep, $numero);
        $getIDEnd->execute();
        $result = $getIDEnd->get_result();

        $getIDEnd->close();
    
        if (!$result) {
            $message = 'Error: Erro ao Cadastrar.';
            echo '<script> window.location.href = "cadastro_colaborador.php?error='.urlencode($message).'"; </script>';
        }
    
        $row = $result->fetch_assoc();
        $idEndereco = $row['ID_ENDERECO'];
    }
    else{
        $idEndereco = $row['ID_ENDERECO'];
    }


    $valEntregador = $conn->prepare("SELECT `ID_ENTREGADOR` FROM `ENTREGADOR` WHERE CPF = ?");
    $valEntregador->bind_param('s', $cpf);
    $valEntregador->execute();
    $resultValL = $valEntregador->get_result();

    if (!$resultVal) {
        $message = 'Error: Erro ao Cadastrar.';
        echo '<script> window.location.href = "cadastro_colaborador.php?error='.urlencode($message).'"; </script>';
    }

    $rowL = $resultValL->fetch_assoc();
    if($rowL == null){
        $stmt = $conn->prepare('INSERT INTO ENTREGADOR (NOME, IDADE, CPF, CAT_CNH, TEM_CAT_A, ID_TRANSPORTADORA, ID_ENDERECO) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('sissbii', $nome, $idade, $cpf, $cat_cnh, $tem_cat_a, $id_transportadora, $idEndereco);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            echo '<script> window.location.pathname = "web/login/login.php"; </script>';
        } else {
            $message = 'Error: Erro ao Cadastrar.';
            echo '<script> window.location.href = "cadastro_colaborador.php?error='.urlencode($message).'"; </script>';
        }
        
        $stmt->close();
    }
    else{
        $message = 'Error: Entregador já Cadastrada.';
        echo '<script> window.location.href = "cadastro_colaborador.php?error='.urlencode($message).'"; </script>';
    }

    $conn->close();
}
?>