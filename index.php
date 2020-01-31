<?php

require_once './model/home.php';
require_once './database/conect.php';


$cadastro = new Cadastro($databasedb, $hostnamedb, $usernamedb, $passworddb);

$senhaIncorreta = '';

if (isset($_POST['ds_email'])) {

    $ds_email = $_POST['ds_email'];
    $cd_password = $_POST['cd_password'];

    session_start();

    if (!empty($ds_email) && !empty($cd_password)) {
        $dados = $cadastro->logarCliente($ds_email, $cd_password);

        if (count($dados) > 0) {
            echo "<script>alert('Cpf invalido');</script>";
            $login = true;
            for ($i = 0; $i < count($dados); $i++) {
                echo "<script>alert('Cpf invalido');</script>";
                foreach ($dados[$i] as $k => $v) {
                    if ($k == "cd_user") {
                        $cd_user = $v;
                        echo "<script>alert('Cpf invalido');</script>";
                    }
                } //Fim do FOREACH
            }
        }

        if (isset($login)) {
            if (isset($cd_user)) {
                $_SESSION['cd_user'] = $cd_user;
            }
            header('location: home.php');
        } else {
            // echo '<p class="cnpj_invalido">Usuário e/ou Senha incorretos!</p>';
            $senhaIncorreta = "Usuário e/ou Senha incorretos!";
        }
    } else {
        $preencha = "Preencha todos os campos!";
    }
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://code.jquery.com/jquery-3.4.1.min.js">
    <title>Index</title>
</head>

<body>
    <div class="card">
        <form action="index.php" method="Post">
            <h1>Login</h1>
            <p>Name</p>
            <input type="email" name="ds_email">
            <p>Password</p>
            <input type="text" name="cd_password">
            <br>
            <input type="submit" id="btn" value="Acessar" />
            <?php

            echo $senhaIncorreta;
            ?>
            <br><br>
            <a href="cadastro.php">Cadastrar Conta</a>
        </form>
    </div>
</body>

</html>