<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'];
    $id = $_POST['id'];
    $peso = $_POST['peso'];
    $altura = $_POST['altura'];
    $largura = $_POST['largura'];
    $profundidade = $_POST['profundidade'];
    $status = $_POST['status'];
    $dataPrevista = $_POST['data_prevista'];
    $observacao = $_POST['observacao'];
    $destinatario = $_POST['destinatario'];
    $stringDestinatario = $_POST['cpf_destinatario'];
    $destinatarioCPFCNJP = str_replace(array('.', '/', '-'), '', $stringDestinatario);
    $entregador = $_POST['entregador'];
    $stringEntregador = $_POST['cpf_entregador'];
    $entregadorCPF = str_replace(array('.', '/', '-'), '', $stringEntregador);
    $loja = $_POST['loja'];
    $stringLoja = $_POST['cnpj_loja'];
    $lojaCNPJ = str_replace(array('.', '/', '-'), '', $stringLoja);
    $stringCep = $_POST['cep'];
    $cep = str_replace(array('.', '/', '-'), '', $stringCep);
    $numero = $_POST['numero'];
    $logradouro = $_POST['logradouro'];
    $bairro = $_POST['bairro'];
    $complemento = $_POST['complemento'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];

    $server = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "lojaentregas";

    $conn = new mysqli($server, $usuario, $senha, $banco);

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

    if ($action == 'update') {
        $query = "SELECT * FROM ENTREGADOR WHERE CPF = :entregadorCPF";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':entregadorCPF', $entregadorCPF);
        $stmt->execute();

        if ($stmt->rowCount() <= 0) {
            $message = 'Error: Entregador não encontrado.';
            echo '<script> window.location.href = "crud_entrega_entregador.php?error=' . urlencode($message) . '"; </script>';
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $idEntregador = $row['ID_ENTREGADOR'];

            $query = "SELECT * FROM LOJA WHERE CNPJ = :lojaCNPJ";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':lojaCNPJ', $lojaCNPJ);
            $stmt->execute();

            if ($stmt->rowCount() <= 0) {
                $message = 'Error: Loja não encontrada.';
                echo '<script> window.location.href = "crud_entrega_entregador.php?error=' . urlencode($message) . '"; </script>';
            } else {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $idLoja = $row['ID_LOJA'];

                $query = "SELECT * FROM ENDERECO WHERE CEP = :cep AND NUMERO = :numero";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':cep', $cep);
                $stmt->bindParam(':numero', $numero);
                $stmt->execute();

                if ($stmt->rowCount() <= 0) {
                    $stmt = $conn->prepare('INSERT INTO ENDERECO (CEP, NUMERO, LOGRADOURO, BAIRRO, COMPLEMENTO, CIDADE, UF) VALUES (?, ?, ?, ?, ?, ?, ?)');
                    $stmt->bind_param('iisssss', $cep, $numero, $logradouro, $bairro, $complemento, $cidade, $uf);
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                    } else {
                        $message = 'Error: Erro ao Cadastrar E.';
                        echo '<script> window.location.href = "crud_entrega_entregador.php?error=' . urlencode($message) . '"; </script>';
                    }

                    $stmt->close();

                    $getIDEnd = $conn->prepare("SELECT `ID_ENDERECO` FROM `ENDERECO` WHERE CEP = ? AND NUMERO = ?");
                    $getIDEnd->bind_param('ss', $cep, $numero);
                    $getIDEnd->execute();
                    $result = $getIDEnd->get_result();

                    $getIDEnd->close();

                    if (!$result) {
                        $message = 'Error: Erro ao Cadastrar Endereço.';
                        echo '<script> window.location.href = "crud_entrega_entregador.php?error=' . urlencode($message) . '"; </script>';
                    }

                    $row = $result->fetch_assoc();
                    $idEndereco = $row['ID_ENDERECO'];
                } else {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    $idEndereco = $row['ID_ENDERECO'];
                }

                $query = "SELECT * FROM DESTINATARIO WHERE CPF_CNPJ = :destinatarioCPFCNJP";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':destinatarioCPFCNJP', $destinatarioCPFCNJP);
                $stmt->execute();

                if ($stmt->rowCount() <= 0) {
                    $stmt = $conn->prepare('INSERT INTO DESTINATARIO (CPF_CNPJ, NOME, ID_ENDERECO) VALUES (?, ?, ?)');
                    $stmt->bind_param('ssi', $destinatarioCPFCNJP, $destinatario, $idEndereco);
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                    } else {
                        $message = 'Error: Erro ao Cadastrar Destinátario.';
                        echo '<script> window.location.href = "crud_entrega_entregador.php?error=' . urlencode($message) . '"; </script>';
                    }

                    $stmt->close();

                    $getIDDes = $conn->prepare("SELECT `ID_DESTINATARIO` FROM `DESTINATARIO` WHERE CPF_CNPJ = ?");
                    $getIDDes->bind_param('s', $destinatarioCPFCNJP);
                    $getIDDes->execute();
                    $result = $getIDDes->get_result();

                    $getIDDes->close();

                    if (!$result) {
                        $message = 'Error: Erro ao Cadastrar D.';
                        echo '<script> window.location.href = "crud_entrega_entregador.php?error=' . urlencode($message) . '"; </script>';
                    }

                    $row = $result->fetch_assoc();
                    $idDestinatario = $row['ID_DESTINATARIO'];
                } else {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    $idDestinatario = $row['ID_DESTINATARIO'];
                }

                $updateDest = $conn->prepare("UPDATE DESTINATARIO SET ID_ENDERECO = ? WHERE ID_DESTINATARIO = ?");
                $updateDest->bind_param('ii', $idEndereco,$idDestinatario);
                $updateDest->execute();
                $result = $updateDest->get_result();

                $updateDest->close();

                $update = $conn->prepare("UPDATE ENCOMENDA SET PESO = ?, ALTURA = ?, LARGURA = ?, PROFUNDIDADE = ?, DATA_PREVISTA = ?, OBSERVACAO = ?, ID_ENTREGADOR = ?, ID_LOJA = ?, ID_DESTINATARIO = ?, ID_STATUS = ? WHERE ID_ENCOMENDA = ?");
                $update->bind_param('ddddssiiiii', $peso, $altura, $largura, $profundidade, $dataPrevista, $observacao, $idEntregador, $idLoja, $idDestinatario, $status, $id);
                $update->execute();

                if ($update->affected_rows > 0) {
                    echo '<script> window.location.href = "crud_entrega_entregador.php?success"; </script>';
                } else {
                    $message = "Error: Erro ao Cadastrar Update.";
                    echo '<script> window.location.href = "crud_entrega_entregador.php?error=' . urlencode($message) . '"; </script>';
                }

                $update->close();
            }
        }
    } else if ($action == 'delete') {
        $delete = $conn->prepare("DELETE FROM ENCOMENDA WHERE ID_ENCOMENDA = ?");
        $delete->bind_param('i', $id);
        $delete->execute();

        if ($delete->affected_rows > 0) {
            echo '<script> window.location.href = "crud_entrega_entregador.php?success"; </script>';
        } else {
            $message = 'Error: Erro ao Cadastrar Delete.';
            echo '<script> window.location.href = "crud_entrega_entregador.php?error=' . urlencode($message) . '"; </script>';
        }

        $delete->close();
    }
}
