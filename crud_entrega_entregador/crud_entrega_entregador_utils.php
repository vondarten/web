<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $id = $_POST['id'];
    $peso = $_POST['peso'];
    $altura = $_POST['altura'];
    $largura = $_POST['largura'];
    $profundidade = $_POST['profundidade'];
    $observacao = $_POST['observacao'];
    $destinatario = $_POST['destinatario'];
    $stringDestinatario = $_POST['cpf_destinatario'];
    $destinatarioCPFCNJP = str_replace(array('.', '/', '-'), '', $stringDestinatario);
    $entregador = $_POST['entregador'];
    $stringEntregador = $_POST['cpf_entregador'];
    $entregadorCPF = str_replace(array('.', '/', '-'), '', $stringEntregador);
    $loja = $_POST['loja'];
    $stringLoja = $_POST['cnpj_loja'];
    $cnpj = str_replace(array('.', '/', '-'), '', $stringLoja);
    $cep = $_POST['cep'];
    $numero = $_POST['numero'];
    $logradouro = $_POST['logradouro'];
    $bairro = $_POST['bairro'];
    $complemento = $_POST['complemento'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];
    $senha = $_POST['senha'];
    $senhaConf = $_POST['senha-conf'];

    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = '';
    $dbName = 'lojaentregas';

    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($conn->connect_error) {
        $message = 'Error: Erro ao Conectar ao Servidor.';
        echo '<script> window.location.href = "crud_entrega_entregador.php?error=' . urlencode($message) . '"; </script>';
    }

    if($action == 'update'){
        echo 'AAAAAAAAAAAAAAAAa';
    }
    else if($action == 'delete'){
        $delete= $conn->prepare("DELETE FROM ENCOMENDA WHERE ID_ENCOMENDA = ?");
        $delete->bind_param('i', $id);
        $delete->execute();

        if ($delete->affected_rows > 0) {
            echo '<script> window.location.href = "crud_entrega_entregador.php?success"; </script>';
        }
        else {
            $message = 'Error: Erro ao Cadastrar.';
            echo '<script> window.location.href = "crud_entrega_entregador.php?error=' . urlencode($message) . '"; </script>';
        }

        $delete->close();
    }
}