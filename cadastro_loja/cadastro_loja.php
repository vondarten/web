<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="./cadastro_loja.css">
    <script src="./cadastro_loja.js"></script>
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

        function returnCEPformated(number){
            const cleanedNumber = number.replace(/\D/g, '');
            const mask = '00.000-000';

            let formattedNumber = '';
            let index = 0;
            for (let i = 0; i < mask.length; i++) {
                if (mask[i] === '0') {
                    formattedNumber += cleanedNumber[index] || '';
                    index++;
                } else {
                    formattedNumber += mask[i];
                }
            }
            return formattedNumber;
        }
        function formatCEP(id) {
            const numberInput = document.getElementById(id);
            const inputValue = numberInput.value;

            const formattedNumber = returnCEPformated(inputValue);
            numberInput.value = formattedNumber;
        }
    </script>
    <title>Cadastro - Loja</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">

            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #103cbe; background-size: cover; background-position: top; background-image: url('../img/caminhao_bg.jpg');">
                <div class="featured-image mb-3" style="width: 250px; height: 250px;"></div>
            </div>

            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="text-align-left header-text mb-4">
                        <h2>Cadastro - Cliente</h2>
                    </div>
                    <div id="alert">
                        <?php
                        if (isset($_GET['error'])) {
                            $errorMessage = urldecode($_GET['error']);
                            echo '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>';
                        } elseif (isset($_GET['success'])) {
                            echo '<div class="alert alert-success" role="alert">Cadastrado com sucesso.</div>';
                        }
                        ?>
                    </div>
                    <form name="Cadastro" action="./cadastro_loja_utils.php" method="POST">
                        <div class="row">
                            <div class="col-12  mb-3">
                                <input id="cadastro-razao-social" type="text" name="razao-social" class="form-control form-control-lg bg-light fs-6" placeholder="Razão Social">
                            </div>

                            <div class="col-12 mb-3">
                                <input id="cadastro-cnpj" type="text" name="cnpj" class="form-control form-control-lg bg-light fs-6" placeholder="CNPJ" onblur="formatInputNumber()">
                            </div>

                            <div class="col-8 mb-3">
                                <input id="cadastro-cep" type="text" name="cep" class="form-control form-control-lg bg-light fs-6" placeholder="CEP" onblur="atualizaCampos();formatCEP('cadastro-cep')">
                            </div>

                            <div class="col-4 mb-3">
                                <input id="cadastro-numero" type="text" name="numero" class="form-control form-control-lg bg-light fs-6" placeholder="Numero">
                            </div>

                            <div class="input-group mb-3">
                                <input id="cadastro-logradouro" type="text" name="logradouro" class="form-control form-control-lg bg-light fs-6" placeholder="Logradouro">
                            </div>

                            <div class="input-group mb-3">
                                <input id="cadastro-bairro" type="text" name="bairro" class="form-control form-control-lg bg-light fs-6" placeholder="Bairro">
                            </div>

                            <div class="input-group mb-3">
                                <input id="cadastro-complemento" type="text" name="complemento" class="form-control form-control-lg bg-light fs-6" placeholder="Complemento">
                            </div>

                            <div class="col-9 mb-3">
                                <input id="cadastro-cidade" type="text" name="cidade" class="form-control form-control-lg bg-light fs-6" placeholder="Cidade">
                            </div>

                            <div class="col-3 mb-3">
                                <input id="cadastro-uf" type="text" name="uf" class="form-control form-control-lg bg-light fs-6" placeholder="UF">
                            </div>

                            <div class="col-12 mb-3">
                                <input id="cadastro-senha" type="password" name="senha" class="form-control form-control-lg bg-light fs-6" placeholder="Senha">
                            </div>

                            <div class="col-12 mb-3">
                                <input id="cadastro-senha-conf" type="password" name="senha-conf" class="form-control form-control-lg bg-light fs-6" placeholder="Confirmar senha">
                            </div>

                            <div class="input-group mb-3">
                                <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Cadastrar</button>
                            </div>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>