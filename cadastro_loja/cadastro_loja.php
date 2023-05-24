<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="./cadastro_loja.css">
    <script src="./cadastro_loja.js"></script>
    <script src="/www/web/shared/consulta_logradouro.js"></script>
    <title>Cadastro - Loja</title>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">

    <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box"
        style="background: #103cbe; background-size: cover; background-position: top; background-image: url('../img/caminhao_bg.jpg');">
        <div class="featured-image mb-3" style="width: 250px; height: 250px;"></div>
    </div>

            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="text-align-left header-text mb-4">
                        <h2>Cadastro - Cliente</h2>
                    </div>
                    <div class="row">

                        <div class="col-12  mb-3">
                            <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Razão Social">
                        </div>

                        <div class="col-12 mb-3">
                            <input id="cadastro-cnpj" type="text" class="form-control form-control-lg bg-light fs-6"
                                placeholder="CNPJ" onblur="formatInputNumber()">
                        </div>

                        <div class="col-8 mb-3">
                            <input id="cadastro-cep" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="CEP" onblur="atualizaCampos()">
                        </div>

                        <div class="col-4 mb-3">
                            <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Numero">
                        </div>

                        <div class="input-group mb-3">
                            <input id="cadastro-logradouro" type="text" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Logradouro">
                        </div>

                        <div class="input-group mb-3">
                            <input id="cadastro-bairro" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Bairro">
                        </div>

                        <div class="input-group mb-3">
                            <input id="cadastro-complemento" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Complemento">
                        </div>

                        <div class="col-9 mb-3">
                            <input id="cadastro-cidade" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Cidade">
                        </div>

                        <div class="col-3 mb-3">
                            <input id="cadastro-uf" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="UF">
                        </div>
                
                        <div class="col-12 mb-3">
                            <input id="cadastro-senha" type="password" class="form-control form-control-lg bg-light fs-6" placeholder="Senha">
                        </div>

                        <div class="col-12 mb-3">
                            <input id="cadastro-senha-conf" type="password" class="form-control form-control-lg bg-light fs-6" placeholder="Confirmar senha">
                        </div>

                        <div class="input-group mb-3">
                            <a href="../login/login.html" class="btn btn-lg btn-primary w-100 fs-6">Cadastrar</a>
                        </div>                        

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>