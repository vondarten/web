<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $string = $_POST['dados'];
    $dados = str_replace(array('.', '/','-'), '', $string);
    $codigo = $_POST['codigo'];

    if ($dados==null || $codigo==null) {
        $message = 'Erro: Preencha os campos';
        echo '<script> window.location.href = "consulta_status.php?error='.urlencode($message).'"; </script>';
    }
    else{
        $dbHost = 'localhost';
        $dbUser = 'root';
        $dbPass = '';
        $dbName = 'lojaentregas';

        $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

        if ($conn->connect_error) {
            $message = 'Error: Erro ao Pesquisar.';
            echo '<script> window.location.href = "consulta_status.php?error='.urlencode($message).'"; </script>';
        }

        $valDados = $conn->prepare("SELECT `ID_DESTINATARIO` FROM `DESTINATARIO` WHERE CPF_CNPJ = ?");
        $valDados->bind_param('s', $dados);
        $valDados->execute();
        $resultVal = $valDados->get_result();

        if (!$resultVal) {
            $message = 'Error: Erro ao Pesquisar.';
            echo '<script> window.location.href = "consulta_status.php?error='.urlencode($message).'"; </script>';
        }

        $valDados->close();

        $row = $resultVal->fetch_assoc();
        if($row == null){
            $message = "Error: CPF/CNPJ Inválido. $dados";
            echo '<script> window.location.href = "consulta_status.php?error='.urlencode($message).'"; </script>';
        }
        else{
            echo "$row[0]";
            $valDados = $conn->prepare("SELECT * FROM `ENCOMENDA` WHERE ID_DESTINATARIO = ? AND ID_ENCOMENDA = ?");
            $valDados->bind_param('ii', $row['ID_DESTINATARIO'],$codigo);
            $valDados->execute();
            $resultVal = $valDados->get_result();
            
            if (!$resultVal) {
                $message = "Error: Erro ao Pesquisar.";
                echo '<script> window.location.href = "consulta_status.php?error='.urlencode($message).' "; </script>';
            }
            
            $rowEncomenda = $resultVal->fetch_assoc();
            $valDados->close();
            if($rowEncomenda == null){
                $message = 'Error: Código não encontrado para esse CPF/CNPJ.';
                echo '<script> window.location.href = "consulta_status.php?error='.urlencode($message).'"; </script>';
            }
            else{
                echo '<script> window.location.href = "consulta_status.php?success"; </script>';
            }
        }
        $conn->close();
    }
}
?>
