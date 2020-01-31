<?php

require_once './model/home.php';
require_once './database/conect.php';

$cadastro = new Cadastro($databasedb, $hostnamedb, $usernamedb, $passworddb);

if (isset($_POST['cadastrar'])) {
    $name = addslashes($_POST['name']);
    $password = addslashes($_POST['password']);
    $email = addslashes($_POST['email']);
    $cpf = addslashes($_POST['cpf']);


    function validaCPF($cpf)
    {

        // Extrai somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{
                    $c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{
                $c} != $d) {
                return false;
            }
        }
        return true;
    }


    if ($name == null and $password == null and $email == null and $cpf == null) {
        echo "<script>alert('Preencha todos os Campos');</script>";
    } elseif (validaCPF($cpf) == false) {
        echo "<script>alert('Cpf invalido');</script>";
    } else {
        $cadastro->cadastrarCliente($name, $password, $email, $cpf);
        header('Location:index.php');
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
    <title>Index</title>
</head>

<body>
    <div class="card" id="">
        <form action="cadastro.php" method="Post">
            <h1>Cadastrar</h1>
            <p>Name</p>
            <input type="text" name="name" id="reset">
            <p>Password</p>
            <input type="text" name="password" id="reset">
            <p>E-mail</p>
            <input type="email" name="email" size="52" maxlength="150" class="formbutton" id="reset">
            <p>CPF</p>
            <input type="text" name="cpf">
            <input type="submit" id="btn" name="cadastrar" value="Acessar" />
            <br><br>
            <a href="cadastro.php">Cadastrar Conta</a>
        </form>
    </div>


</body>

</html>