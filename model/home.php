<?php

class Cadastro
{
    private $pdo;


    public function __construct($dbname, $host, $user, $senha)
    {
        try {
            $this->pdo = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8",
                $user,
                $senha,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
        } catch (PDOException $e) {
            echo 'Erro com banco de dados: ' . $e->getMessage();
            exit();
        } catch (Exception $e) {
            echo 'Erro Genérico: ' . $e->getMessage();
            exit();
        }
    }
    public function cadastrarCliente($name, $password, $email, $cpf)
    {
        $cmd = $this->pdo->prepare("INSERT INTO tb_users (nm_user,cd_password,cd_cpf,ds_email) VALUES(:a,:b, :c, :d)");
        $cmd->bindValue(":a", $name);
        $cmd->bindValue(":b", $password);
        $cmd->bindValue(":c", $cpf);
        $cmd->bindValue(":d", $email);

        $cmd->execute();
        return true;
    }
    public function logarCliente($ds_email, $cd_password)
    {
        $res_lastId = array();
        $cmd = $this->pdo->prepare("SELECT cd_user FROM tb_users WHERE ds_email = :a AND cd_password=:b");
        $cmd->bindValue(":a", $ds_email);
        $cmd->bindValue(":b", $cd_password);
        $cmd->execute();
        $res_lastId = $cmd->fetchAll(PDO::FETCH_ASSOC);

        return $res_lastId;
    }
}


class Cadastro_home
{
    private $pdo;


    public function __construct($dbname, $host, $user, $senha)
    {
        try {
            $this->pdo = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8",
                $user,
                $senha,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
        } catch (PDOException $e) {
            echo 'Erro com banco de dados: ' . $e->getMessage();
            exit();
        } catch (Exception $e) {
            echo 'Erro Genérico: ' . $e->getMessage();
            exit();
        }
    }
    public function cadastrarAgenda($nm_name, $ds_address, $dt_date, $cd_cnpj, $cd_user)
    {
        $cmd = $this->pdo->prepare("INSERT INTO tb_cliente (nm_name,ds_address,dt_date,cd_cnpj, cd_user) VALUES(:a,:b, :c, :d, :e)");
        $cmd->bindValue(":a", $nm_name);
        $cmd->bindValue(":b", $ds_address);
        $cmd->bindValue(":c", $dt_date);
        $cmd->bindValue(":d", $cd_cnpj);
        $cmd->bindValue(":e", $cd_user);

        $cmd->execute();
        return true;
    }
    public function selectAgenda($cd_user)
    {
        $res_lastId = array();
        $cmd = $this->pdo->prepare("SELECT * FROM tb_cliente WHERE cd_user = :a");
        $cmd->bindValue(":a", $cd_user);
        $cmd->execute();
        $res_lastId = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res_lastId;
    }
    public function selectEdit($cd_user, $editar)
    {
        $res = array();
        $cmd = $this->pdo->prepare("SELECT * FROM tb_cliente WHERE cd_user = :a AND cd_cliente = :b ");
        $cmd->bindValue(":a", $cd_user);
        $cmd->bindValue(":b", $editar);
        $cmd->execute();
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
    public function updateAgenda($nm_name, $ds_address, $dt_date, $cnpj, $editar)
    {

        $cmd = $this->pdo->prepare("UPDATE tb_cliente SET nm_name = :a, ds_address=:b, dt_date=:c, cd_cnpj=:d WHERE cd_cliente= :e ");
        $cmd->bindValue(":a", $nm_name);
        $cmd->bindValue(":b", $ds_address);
        $cmd->bindValue(":c", $dt_date);
        $cmd->bindValue(":d", $cnpj);
        $cmd->bindValue(":e", $editar);
        $cmd->execute();
        return true;
    }
    public function deleteAgenda($delete)
    {
        $res = array();
        $cmd = $this->pdo->prepare("DELETE FROM tb_cliente WHERE cd_cliente = :a");
        $cmd->bindValue(":a", $delete);
        $cmd->execute();
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
}
