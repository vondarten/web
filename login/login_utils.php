<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $string = $_POST['dados'];
    $dados = str_replace(array('.', '/','-'), '', $string);
    $senha = $_POST['senha'];

    if (!$dados|| !$senha) {
        $message = 'Preencha os campos';
        echo '<script> window.location.href = "login.php?error='.urlencode($message).'"; </script>';
    }

    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = '';
    $dbName = 'lojaentregas';

    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($conn->connect_error) {
        $message = 'Error: Erro ao Cadastrar.';
        echo '<script> window.location.href = "login.php?error='.urlencode($message).'"; </script>';
    }

    $temp = strlen($dados);
    if($temp == 11){
        $stmt = $conn->prepare("SELECT * FROM ENTREGADOR WHERE CPF = ? AND SENHA = ?");
        $stmt->bind_param('ss', $dados, $senha);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $name = "idEntregador";
            $value = $row['ID_ENTREGADOR'];
            $expiry = time() + (86400 * 30); // Expiry time in seconds (30 days from now)
            $path = "/"; // Path on the domain where the cookie is accessible
        
            setcookie($name, $value, $expiry, $path);
            echo '<script> window.location.pathname = "www/web/admin_entregador/admin_entregador.php"; </script>';
        } else {
            $temp = $stmt->num_rows;
            $message = "CPF ou Senha inválidos";
            echo '<script> window.location.href = "login.php?error='.urlencode($message).'"; </script>';
        }
        
        $stmt->close();
    }
    else if($temp == 14){
        $stmt = $conn->prepare("SELECT * FROM LOJA WHERE CNPJ = ? AND SENHA = ?");
        $stmt->bind_param('ss', $dados, $senha);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $name = "idLoja";
            $value = $row['ID_LOJA'];
            $expiry = time() + (86400 * 30);
            $path = "/";
        
            setcookie($name, $value, $expiry, $path);
            echo '<script> window.location.pathname = "www/web/admin_loja/admin_loja.php"; </script>';
        } else {
            $temp = $stmt->num_rows;
            $message = "CNPJ ou Senha inválidos";
            echo '<script> window.location.href = "login.php?error='.urlencode($message).'"; </script>';
        }
        
        $stmt->close();
    }
    else {
        $message = 'Valor inválido para CNPJ ou CPF';
        echo '<script> window.location.href = "login.php?error='.urlencode($message).'"; </script>';
    }
}
?>