<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="./login.css">
    <script src="./login.js"></script>
    <title>Seja bem-vindo(a)!</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area" style="height: 70vh">

            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #103cbe; background-size: cover; background-position: top; background-image: url('../img/caminhao_bg.jpg');">
                <div class="featured-image mb-3" style="width: 250px; height: 250px;"></div>
            </div>

            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="text-align-left header-text mb-4" style="margin-top: 100px;">
                        <h2>Seja bem-vindo(a)!</h2>
                    </div>
                    <div id="alert">
                        <?php
                        // Check for error or success messages in the URL query parameters
                        if (isset($_GET['error'])) {
                            $errorMessage = urldecode($_GET['error']);
                            echo '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>';
                        } elseif (isset($_GET['success'])) {
                            echo '<div class="alert alert-success" role="alert">Cadastrado com sucesso.</div>';
                        }
                        ?>
                    </div>
                    <div class="row">
                        <form name="Cadastro" action="./login_utils.php" method="POST">
                            <div class="col-12 mb-3">
                                <input id="login-cpf-cnpj" type="text" name="dados"class="form-control form-control-lg bg-light fs-6" placeholder="CPF ou CNPJ" onblur="formatInputNumber()">
                            </div>

                            <div class="col-12 mb-3">
                                <input id="cadastro-uf" type="password" name="senha" class="form-control form-control-lg bg-light fs-6" placeholder="Senha">
                            </div>

                            <div class="input-group mb-3">
                                <button type="submit" class="btn btn-lg btn-primary w-100 fs-6" onclick="redirect()">
                                    Entrar
                                </button>
                            </div>

                            <div class="input-group">
                                <p>Não possui uma conta?</p> <br>
                                <a href="../cadastro_loja/cadastro_loja.php" style="text-decoration: none;">&nbsp;&nbsp;Cadastre-se</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>