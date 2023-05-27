<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="./admin_entregador.css">
    <script>
        function setCookieAndRedirect(rowID) {
            // Send a POST request to the PHP file with the row ID
            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", "your_php_file.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("rowID=" + rowID);

            // Redirect to the desired page
            window.location.href = "/www/web/crud_entrega/crud_entrega.html";
        }
    </script>
    <script src="/shared/consulta_logradouro.js"></script>
    <title>Admin - Entregador</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-center ml-3 bg-white shadow">
        <div class="row col-12 d-flex">

            <div class="col-4">
                <a class="navbar-brand d-flex align-items-center mx-5" href="#">
                    <img src="../img/logo.png" alt="Logo" class="logo-img">
                    <b class="mr-2 navbar-text">IP Logistics</b>
                </a>
            </div>

            <div class="col-4">
                <ul class="navbar-nav align-items-center justify-content-center" style="height: 100%;">
                    <li class="nav-item mx-3">
                        <a class="nav-link navbar-text " href="../admin_entregador/admin_entregador.html">Entregas</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link navbar-text" href="../cadastro_colaborador/cadastro_colaborador.html">Cadastrar colaborador</a>
                    </li>
                </ul>
            </div>

            <div class="col-4 ">
                <ul class="navbar-nav align-items-center justify-content-end" style="height: 100%;">
                    <li class="nav-item mx-5">
                        <a class="nav-link navbar-text" href="#"> <span style="color: grey; font-weight: 500;">Olá, </span><b>Entregador</b></a>
                    </li>
                    <li class="nav-item mx-5">
                        <a class="nav-link navbar-text" href="../login/login.html">Sair</a>
                    </li>
                </ul>
            </div>
        </div>    
    </nav>

    <div class="container d-flex justify-content-center align-items-center". style="margin-top: 3cm;">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <form method="POST" action="">
                <div class="row col-12 ">
                    <div class="col-11">
                        <input class="form-control" type="text" name="searchNumber" placeholder="Pesquise por Nº">
                    </div>
                    <div class="col-1">
                        <button type="submit" name="searchButton" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-search" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-center">Nº</th>
                        <th class="text-center">Peso</th>
                        <th class="text-center">Dimensões</th>
                        <th class="text-center">Data Prevista</th>
                        <th class="text-center">Destinatário</th>   
                        <th class="text-center">Status</th>
                        <th class="text-center">Observações</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                <?php
                    
                    // Connect to your MySQL database
                    $server = "localhost";
                    $usuario = "root";
                    $senha = "";
                    $banco = "lojaentregas";
                    
                    $conn = new mysqli($server, $usuario, $senha, $banco);
                    if ($conn->connect_error) {
                        die('Connection failed: ' . $conn->connect_error);
                    }
                    
                    // Check if the search button is clicked
                    if (isset($_POST['searchButton'])) {
                        $searchNumber = $_POST['searchNumber'];
                        if($searchNumber==null){
                            $result = $conn->query("SELECT * FROM encomenda");
                            if (!$result) {
                                die('Query failed: ' . $conn->error);
                            }
                        }
                        else{
                            // Query the database based on the search number
                            $result = $conn->query("SELECT * FROM encomenda WHERE ID_ENCOMENDA = $searchNumber");
                            if (!$result) {
                                die('Query failed: ' . $conn->error);
                            }
                        }
                    } else {
                        // If the search button is not clicked, retrieve all records
                        $result = $conn->query("SELECT * FROM encomenda");
                        if (!$result) {
                            die('Query failed: ' . $conn->error);
                        }
                    }
                    
                    while ($row = $result->fetch_assoc()) {
                        $idrow = $row['ID_STATUS'];

                        $result1 = $conn->query("SELECT NOME FROM STATUS WHERE ID_STATUS = $idrow");
                        if (!$result1) {
                            die('Query failed: ' . $conn->error);
                        }
                        $statusName = $result1->fetch_assoc();

                        echo '<tr onclick="setCookieAndRedirect('.$row['ID_ENCOMENDA'].');" class="link-table">';
                        echo '<td class="text-center">' . $row['ID_ENCOMENDA'] . '</td>';
                        echo '<td class="text-center">' . $row['PESO'] . '</td>';
                        echo '<td class="text-center">' . $row['ALTURA'] . 'cm x ' . $row['LARGURA'] . 'cm x ' . $row['PROFUNDIDADE'] .  'cm</td>';
                        echo '<td class="text-center">' . $row['DATA_PREVISTA'] . '</td>';
                        echo '<td class="text-center">' . $row['ID_DESTINATARIO'] . '</td>';
                        echo '<td class="text-center">' . $statusName['NOME'] . '</td>';
                        echo '<td class="text-center">' . $row['OBSERVACAO'] . '</td>';
                        echo '</tr>';
                    }
                    
                    // Close the database connection
                    $conn->close();

                    if (isset($_POST['rowClicked'])) {
                        // Set the cookie
                        $name = "username";
                        $value = "John Doe";
                        $expiry = time() + (86400 * 30); // Expiry time in seconds (30 days from now)
                        $path = "/"; // Path on the domain where the cookie is accessible
                    
                        setcookie($name, $value, $expiry, $path);
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>