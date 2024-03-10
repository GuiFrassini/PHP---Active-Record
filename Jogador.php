<?php

use pdo_poo\Database;

class jogador
{
    private int $id;
    private string $name;
    private string $username;
    private string $email;
    private string $senha;
    private string $createdata;

    public function __construct($id,$name, $username, $email, $senha, $createdata)
    {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->senha = $senha;
        $this->createdata = $createdata;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;

    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    public function getCreatedata()
    {
        return $this->createdata;
    }

    public function setCreatedata($createdata)
    {
        $this->createdata = $createdata;
    }



    public function criarJogador() {
        $db = Database::getInstance();

        if($this->id){

            $stmt = $db->prepare("UPDATE jogador SET name = :name ,username = :username ,email = :email, senha = :senha, data_cadastro =:data_cadastro
                    WHERE id = :id");

            $stmt -> bindParam(':id',$this->id);
        }
        else{
            $stmt = $db->prepare ("INSERT INTO jogador (name,username,email,senha,data_cadastro)
                    VALUES (:name,:username,:email,:senha,:data_cadastro)");

        }

        $stmt -> bindParam(':name',$name);
        $stmt -> bindParam(':username',$username);
        $stmt -> bindParam(':email',$email);
        $stmt -> bindParam(':senha',$senha);
        $stmt -> bindParam(':data_cadastro',$data_cadastro);

        $stmt->execute();
        echo '<button><a href="index.html">Voltar</a></button>';
    }

    public function listaJogadores()
    {
        $db = Database::getInstance();

        $stmt = $db->prepare('Select * from jogador');
        $stmt ->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    public function updateJogador(jogador $jogador) {
        $db = Database::getInstance();

        $id = $jogador->getId();
        $name = $jogador->getName();
        $username = $jogador->getUsername();
        $email = $jogador->getEmail();
        $senha = $jogador->getSenha();
        $data_cadastro = $jogador->getCreatedata();

        $stmt = $db->prepare("UPDATE jogador SET name = :name ,username = :username ,email = :email, senha = :senha, data_cadastro =:data_cadastro
                    WHERE id = :id");

        $stmt -> bindParam(':id',$id);
        $stmt -> bindParam(':name',$name);
        $stmt -> bindParam(':username',$username);
        $stmt -> bindParam(':email',$email);
        $stmt -> bindParam(':senha',$senha);
        $stmt -> bindParam(':data_cadastro',$data_cadastro);

        $stmt ->execute();
        echo '<button><a href="visualizar.html">Voltar</a></button>';
    }

    public function geterID($id)
    {
        $db = Database::getInstance();
        //bindParam troca a os parametros '' pela variavel neste caso;
        $stmt = $db->prepare('Select * from jogador where id =:id');
        $stmt ->bindParam('id',$id);
        $stmt ->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result){
            $jogador = new jogador();
            $jogador -> setId($result['id']);
            $jogador -> setName($result['name']);
            $jogador -> setUsername($result['username']);
            $jogador -> setEmail($result['email']);
            $jogador -> setSenha($result['senha']);
            $jogador -> setCreatedata($result['data_cadastro']);
            return $jogador;
        }
        return null;

    }
    public function excluirUsuario(jogador $jogador)
    {
        $db = Database::getInstance();

        $id = $jogador->getId();

        $stmt = $db->prepare("delete from jogador where id = :id");
        $stmt ->bindParam('id',$id);
        $stmt ->execute();
        echo '<button><a href="index.html">Voltar</a></button>';

    }
}