<?php
require_once 'banco.php';
require_once 'Jogador.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use pdo_poo\Database;

$requestMethod = $_SERVER['REQUEST_METHOD'] ?? '';

if ($requestMethod === 'POST'){
    $action = $_POST['action'];

}
    switch ($action){

        case 'cadastrar':

            $id = $_POST['id'];
        $name = $_POST['name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $createdata = date('Y-m-d');

        $jogador = new jogador($id,$name, $username, $email, $senha, $createdata);

        $jogador -> setId($id);
        $jogador -> setName($name);
        $jogador -> setUsername($username);
        $jogador -> setEmail($email);
        $jogador -> setSenha($senha);
        $jogador -> setCreatedata($createdata);

        $jogador->criarJogador($jogador);

        break;


        case 'listar':
            $result = $JogadorMapper->listaJogadores();

            $linhasDeUsuarios = '';

            foreach ($result as $item) {
                $linhasDeUsuarios .= '<tr>';
                $linhasDeUsuarios .= '<td>'. $item['id'] .'</td>';
                $linhasDeUsuarios .= '<td>'. $item['name'] .'</td>';
                $linhasDeUsuarios .= '<td>'. $item['username'] .'</td>';
                $linhasDeUsuarios .= '<td>'. $item['email'] .'</td>';
                $linhasDeUsuarios .= '<td>'. $item['senha'] .'</td>';
                $linhasDeUsuarios .= '<td>'. $item['data_cadastro'] .'</td>';
                $linhasDeUsuarios.= '<td>';
                $linhasDeUsuarios .= '<form action="setPHP.php" method="POST">';
                $linhasDeUsuarios .= '<input type="hidden" name="id" value="' . $item['id'] . '">';
                $linhasDeUsuarios .= '<button type="submit" name="action" value="editar" style="background:darkseagreen;padding: 8px; border-radius: 5px;margin-right: 10px">Editar</button>';
                $linhasDeUsuarios .= '<button type="submit" name="action" value="ConfirmaDelete" style="background:red;padding: 8px; border-radius: 5px">Excluir</button>';
                $linhasDeUsuarios.= '</form>';
                $linhasDeUsuarios .= '</td>';
                $linhasDeUsuarios .= '</tr>';

            }

            $template = file_get_contents(__DIR__ .'/visualizar.html');
            $template = str_replace('<!--AQUI_VEM_AS_LINHAS-->', $linhasDeUsuarios,$template);
            echo $template;
            break;

        case 'editar':

            $setId = $_POST['id'];
            $setjogador = $JogadorMapper->geterID($setId);
            $template = file_get_contents(__DIR__.'/editar.html');

            $template = str_replace('{{id}}', $setjogador->getId(), $template);
            $template = str_replace('{{name}}', $setjogador->getName(), $template);
            $template = str_replace('{{username}}', $setjogador->getUsername(), $template);
            $template = str_replace('{{email}}', $setjogador->getEmail(), $template);
            $template = str_replace('{{senha}}', $setjogador->getSenha(), $template);
            $template = str_replace('{{createdata}}', $setjogador->getCreatedata(), $template);

            echo $template;

            break;

        case 'update':
            $buscaId = $_POST['id'];
            $alterajogador = $JogadorMapper->geterID($buscaId);

            $alterajogador->setName($_POST['name'] ?? '');
            $alterajogador->setUsername($_POST['username'] ?? '');
            $alterajogador->setEmail($_POST['email'] ?? '');
            $alterajogador->setSenha($_POST['senha'] ?? '');
            $alterajogador->setCreatedata($_POST['createdata'] ?? '');

            $JogadorMapper->updateJogador($alterajogador);

            break;

        case 'delete':
            $id = $_POST['id'];

            $jogador = new jogador();
            $jogador ->setId($id);
            $JogadorMapper->excluirUsuario($jogador);

            break;

        case 'ConfirmaDelete':

            $buscaId = $_POST['id'];

            $alterajogador = $JogadorMapper->geterId($buscaId);
            $template = file_get_contents(__DIR__.'/excluir.html');

            $template = str_replace('{{id}}', $alterajogador->getId(), $template);
            $template = str_replace('{{name}}', $alterajogador->getName(), $template);
            $template = str_replace('{{username}}', $alterajogador->getUsername(), $template);
            $template = str_replace('{{email}}', $alterajogador->getEmail(), $template);
            $template = str_replace('{{senha}}', $alterajogador->getSenha(), $template);
            $template = str_replace('{{createdata}}', $alterajogador->getCreatedata(), $template);
            echo $template;

            break;
         }