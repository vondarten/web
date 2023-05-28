<?php
if (isset($_POST['confirmar'])) {
    // Retrieve the input value
    $orderPeso = $_POST['order-peso'];

    // Database connection details
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

    // Prepare and execute the update query
    $query = "UPDATE ENCOMENDA SET PESO = :peso WHERE ID_ENCOMENDA = :idEncomenda";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':peso', $orderPeso);
    $stmt->bindParam(':idEncomenda', $idEncomenda);

    if ($stmt->execute()) {
        // Update successful, you can redirect or display a success message
    } else {
        // Update failed, handle the error
    }
}
?>