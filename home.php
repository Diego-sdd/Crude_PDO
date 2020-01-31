<?php
session_start();

if ($_SESSION['cd_user'] == "") {
    header('location: index.php');
}
require_once './model/home.php';
require_once './database/conect.php';
include('./valida.php');

$cadastro = new Cadastro_home($databasedb, $hostnamedb, $usernamedb, $passworddb);

if (isset($_POST['cadastrar'])) {
    $nm_name = addslashes($_POST['nm_name']);
    $ds_address = addslashes($_POST['ds_address']);
    $dt_date = addslashes($_POST['dt_date']);
    $cnpj = addslashes($_POST['cd_cnpj']);


    echo validar_cnpj($cnpj);
    if ($nm_name == null and $ds_address == null and $dt_date == null and $cnpj == null) {
        echo "<script>alert('Preencha todos os Campos');</script>";
    } elseif (validar_cnpj($cnpj) == false) {
        echo "<script>alert('Cnpj invalido');</script>";
    } else {
        $res_editar = $cadastro->cadastrarAgenda($nm_name, $ds_address, $dt_date, $cnpj, $_SESSION['cd_user']);
    }
}
$nm_name = '';
$ds_address = '';
$dt_date = '';
$cd_cnpj = '';
//Editar
if (isset($_POST['editar'])) {
    $_SESSION['editar'] = addslashes($_POST['editar']);

    //Se a variável $res_editar existir, os dados aparecerão no value do form
    $res_editar = $cadastro->selectEdit($_SESSION['cd_user'], $_SESSION['editar']);
    if (count($res_editar) > 0) {
        for ($i = 0; $i < count($res_editar); $i++) {
            $id = $i;
            foreach ($res_editar[$i] as $k => $v) {
                if ($k == "nm_name") {
                    $nm_name = $v;
                }
                if ($k == "nm_name") {
                    $nm_name = $v;
                }
                if ($k == "ds_address") {
                    $ds_address = $v;
                }
                if ($k == "dt_date") {
                    $dt_date = $v;
                }
                if ($k == "cd_cnpj") {
                    $cd_cnpj = $v;
                }
                if ($k == "cd_cliente") {
                    $btn_editar = $v;
                }
            }
        }
    }
}


if (isset($_POST['update'])) {

    $nm_name = addslashes($_POST['nm_name']);
    $ds_address = addslashes($_POST['ds_address']);
    $dt_date = addslashes($_POST['dt_date']);
    $cnpj = addslashes($_POST['cd_cnpj']);

    if ($nm_name == null and $ds_address == null and $dt_date == null and $cnpj == null) {
        echo "<script>alert('Preencha todos os Campos');</script>";
    } elseif (validar_cnpj($cnpj) == false) {
        echo "<script>alert('Cnpj invalido');</script>";
    } else {
        echo "<script>alert('$nm_name, $ds_address, $dt_date, $cnpj, $_SESSION[editar] ');</script>";

        $cadastro->updateAgenda($nm_name, $ds_address, $dt_date, $cnpj, $_SESSION['editar']);
    }
}

if (isset($_POST['delete'])) {
    $_SESSION['delete'] = addslashes($_POST['delete']);
    $cadastro->deleteAgenda($_SESSION['delete']);
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="sair.php">Sair</a>
                </li>

            </ul>
        </div>
    </nav>

    <section class="container">
        <br><br>
        <section class="row">
            <form action="home.php" method="POST">
                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control" name="nm_name" value="<?php echo $nm_name; ?>" placeholder="Name">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="ds_address" value="<?php echo $ds_address; ?>" placeholder="Endereço">
                    </div>
                    <div class="col">
                        <input type="date" class="form-control" name="dt_date" value="<?php echo $dt_date; ?>" placeholder="Data">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="cd_cnpj" value="<?php echo $cd_cnpj; ?>" placeholder="CNPJ">
                    </div>

                    <!-- <button type="button" class="btn btn-primary btn-md" name="cadastrar">Cadastrar</button> -->
                    <button type="submit" id="btn" class="btn btn-primary" name="<?php if (isset($res_editar)) {
                                                                                        echo 'update';
                                                                                    } else {
                                                                                        echo "cadastrar";
                                                                                    } ?>"><?php if (isset($res_editar)) {
                                                                                                echo "Editar";
                                                                                            } else {
                                                                                                echo "Cadastrar";
                                                                                            } ?></button>
                </div>
                <br><br>
            </form>



            <table class="table">

                <thead class="thead-dark">
                    <tr>
                        <th scope="col-md-1">#</th>
                        <th scope="col-md-2">Nome</th>
                        <th scope="col-md-5">Endereço</th>
                        <th scope="col-md-2">Date</th>
                        <th scope="col-md-2">CNPJ</th>
                        <th scope="col-md-2">Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $dados = $cadastro->selectAgenda($_SESSION['cd_user']);
                    //Só vai mostrar os dados, se o array não estiver vazio
                    if (count($dados) > 0) {
                        for ($i = 0; $i < count($dados); $i++) {
                            $id = $i;
                            foreach ($dados[$i] as $k => $v) {
                                if ($k == "cd_cliente") {
                                    $cd_cliente = $v;
                                }
                                if ($k == "nm_name") {
                                    $nm_name = $v;
                                }
                                if ($k == "ds_address") {
                                    $ds_address = $v;
                                }
                                if ($k == "dt_date") {
                                    $dt_date = $v;
                                    $dt_date = (new DateTime($v))->format('d/m/Y');
                                }
                                if ($k == "cd_cnpj") {
                                    $cd_cnpj = $v;
                                }
                            }
                    ?>
                            <tr>

                                <th scope="row"><?php echo $id; ?></th>
                                <td><?php echo $nm_name; ?></td>
                                <td><?php echo $ds_address; ?></td>
                                <td><?php echo $dt_date; ?></td>
                                <td><?php echo $cd_cnpj; ?></td>
                                <td>
                                    <form action="" method="POST" id="linha">
                                        <button type="submit" name="editar" value="<?php echo $cd_cliente; ?>" class="btn btn-circle btn-lg"><img src="img/edit.png" style="width: 40px; margin-left:-12px;margin-top:-5px;"></button>

                                        <button type="submit" name="delete" value="<?php echo $cd_cliente; ?>" class="btn btn-circle btn-lg"><img src="img/delete.png" style="width: 40px; margin-left:-12px;margin-top:-5px;"></button>

                                    </form>
                                </td>
                            </tr>
                    <?php


                        }
                    }

                    ?>
                </tbody>
            </table>




        </section>
    </section>
</body>

</html>
<style>
    #linha {
        display: inline;
        float: left;
    }

    .btn-circle {
        width: 30px;
        height: 30px;
        text-align: center;
        padding: 6px 0;
        font-size: 12px;
        line-height: 1.428571429;
        border-radius: 15px;
    }

    .btn-circle.btn-lg {
        width: 50px;
        height: 50px;
        padding: 10px 16px;
        font-size: 18px;
        line-height: 1.33;
        border-radius: 25px;
    }

    .btn-circle.btn-xl {
        width: 70px;
        height: 70px;
        padding: 10px 16px;
        font-size: 24px;
        line-height: 1.33;
        border-radius: 35px;
    }
</style>