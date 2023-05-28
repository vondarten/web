<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="./cadastro_colaborador.css">
    <script src="./cadastro_colaborador.js"></script>
    <script src="/shared/consulta_logradouro.js"></script>
    <script>
        async function consultaLogradouro() {
            const cep = document.getElementById("cadastro-cep").value.replace(/[^0-9]+/, '');
            const url = `https://viacep.com.br/ws/${cep}/json/`;

            const response = await fetch(url);
            const json = await response.json();

            return json;
        }

        async function atualizaCampos() {
            const json = await consultaLogradouro();

            document.getElementById("cadastro-logradouro").value = json.logradouro;
            document.getElementById("cadastro-bairro").value = json.bairro;
            document.getElementById("cadastro-complemento").value = json.complemento;
            document.getElementById("cadastro-cidade").value = json.localidade;
            document.getElementById("cadastro-uf").value = json.uf;
        }
    </script>
    <title>Cadastro - Colaborador</title>
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
                        <a class="nav-link navbar-text " href="../admin_entregador/admin_entregador.php">Entregas</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link navbar-text" href="../cadastro_colaborador/cadastro_colaborador.php">Cadastrar colaborador</a>
                    </li>
                </ul>
            </div>

            <div class="col-4 ">
                <ul class="navbar-nav align-items-center justify-content-end" style="height: 100%;">
                    <li class="nav-item mx-5">
                        <a class="nav-link navbar-text" href="#"> <span style="color: grey; font-weight: 500;">Olá, </span><b>Entregador</b></a>
                    </li>
                    <li class="nav-item mx-5">
                        <a class="nav-link navbar-text" href="../login/login.php">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container d-flex justify-content-center align-items-center min-vh-100" style="margin-top: -3%;">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">

            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #103cbe; background-size: cover; background-position: bottom; background-image: url('../img/colaborador_bg.jpg');">
            </div>

            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <form name="Cadastro" action="./cadastro_colaborador_utils.php" method="POST">
                        <div class="text-align-left header-text mb-4">
                            <h3>Cadastro - Colaborador</h3>
                        </div>
                        <div class="row">
                            <div class="col-12  mb-3">
                                <input type="text" name="nome" class="form-control form-control-lg bg-light fs-6" placeholder="Nome">
                            </div>
                            <div class="col-8 mb-3">
                                <input id="login-cpf-cnpj" name="cpf" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="CPF" onblur="formatInputNumber()">
                            </div>
                            <div class="col-4 mb-3">
                                <input type="text" name="idade" class="form-control form-control-lg bg-light fs-6" placeholder="Idade">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <input id="cadastro-cep" name="cep" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="CEP" onblur="atualizaCampos()">
                            </div>
                            <div class="col-6 mb-3">
                                <input type="text" name="numero" class="form-control form-control-lg bg-light fs-6" placeholder="Numero">
                            </div>
                            <div class="input-group mb-3">
                                <input id="cadastro-logradouro" name="logradouro" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Logradouro">
                            </div>

                            <div class="input-group mb-3">
                                <input id="cadastro-bairro" name="bairro" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Bairro">
                            </div>

                            <div class="input-group mb-3">
                                <input id="cadastro-complemento" name="complemento" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Complemento">
                            </div>

                            <div class="col-9 mb-3">
                                <input id="cadastro-cidade" name="cidade" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Cidade">
                            </div>

                            <div class="col-3 mb-3">
                                <input id="cadastro-uf" name="uf" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="UF">
                            </div>
                            <div class="col-12">
                                <select name="cat_cnh" class="form-select form-select-lg bg-light fs-6">
                                    <option selected hidden disabled>Categoria CNH</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <div class="form-check my-3">
                                    <input name="tem_cat_a" class="form-check-input" type="checkbox" value="true" id="flexCheckChecked">
                                    <label class="form-check-label" for="flexCheckChecked">
                                        Você também possui a Categoria A?
                                    </label>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <button class="btn btn-lg btn-primary w-100 fs-6">Cadastrar</button>
                            </div>
                        </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</body>

</html>