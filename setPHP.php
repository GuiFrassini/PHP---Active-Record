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

            $id = isset($_POST['id']) ? $_POST['id'] : null;
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

        $jogador->criarJogador();

        break;


        case 'listar':
            $jogador = jogador::listaJogadores();

            $linhasDeUsuarios = '';

            foreach ($jogador as $item) {
                $linhasDeUsuarios .= '<tr>';
                $linhasDeUsuarios .= '<td>'. $item->getId() .'</td>';
                $linhasDeUsuarios .= '<td>'. $item->getName() .'</td>';
                $linhasDeUsuarios .= '<td>'. $item->getUsername() .'</td>';
                $linhasDeUsuarios .= '<td>'. $item->getEmail() .'</td>';
                $linhasDeUsuarios .= '<td>'. $item->getSenha() .'</td>';
                $linhasDeUsuarios .= '<td>'. $item->getCreatedata() .'</td>';
                $linhasDeUsuarios.= '<td>';
                $linhasDeUsuarios .= '<form action="setPHP.php" method="POST">';
                $linhasDeUsuarios .= '<input type="hidden" name="id" value="' . $item->getId() . '">';
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

            $UpdateJogador = new jogador($setId);

            $BuscaDados = $UpdateJogador->geterID($setId);

            $UpdateJogador->setId($BuscaDados->getId());
            $UpdateJogador->setName($BuscaDados->getName());
            $UpdateJogador->setUserName($BuscaDados->getUserName());
            $UpdateJogador->setEmail($BuscaDados->getEmail());
            $UpdateJogador->setSenha($BuscaDados->getSenha());
            $UpdateJogador->setCreatedata($BuscaDados->getCreatedata());

            $template = file_get_contents(__DIR__.'/editar.html');

            $template = str_replace('{{id}}', $UpdateJogador->getId(), $template);
            $template = str_replace('{{name}}', $UpdateJogador->getName(), $template);
            $template = str_replace('{{username}}', $UpdateJogador->getUsername(), $template);
            $template = str_replace('{{email}}', $UpdateJogador->getEmail(), $template);
            $template = str_replace('{{senha}}', $UpdateJogador->getSenha(), $template);
            $template = str_replace('{{createdata}}', $UpdateJogador->getCreatedata(), $template);

            echo $template;

            break;

        case 'update':
            $buscaId = $_POST['id'];
            $alterajogador = new jogador($buscaId);

            $alterajogador->setName($_POST['name'] ?? '');
            $alterajogador->setUsername($_POST['username'] ?? '');
            $alterajogador->setEmail($_POST['email'] ?? '');
            $alterajogador->setSenha($_POST['senha'] ?? '');
            $alterajogador->setCreatedata($_POST['createdata'] ?? '');

            $alterajogador->criarJogador();

            break;

        case 'delete':
            $id = $_POST['id'];

            $jogador = new jogador($id);
            $jogador ->setId($id);
            $jogador->excluirUsuario();

            break;

        case 'ConfirmaDelete':

            $setId = $_POST['id'];

            $UpdateJogador = new jogador($setId);

            $BuscaDados = $UpdateJogador->geterID($setId);

            $UpdateJogador->setId($BuscaDados->getId());
            $UpdateJogador->setName($BuscaDados->getName());
            $UpdateJogador->setUserName($BuscaDados->getUserName());
            $UpdateJogador->setEmail($BuscaDados->getEmail());
            $UpdateJogador->setSenha($BuscaDados->getSenha());
            $UpdateJogador->setCreatedata($BuscaDados->getCreatedata());


            $template = file_get_contents(__DIR__.'/excluir.html');

            $template = str_replace('{{id}}', $UpdateJogador->getId(), $template);
            $template = str_replace('{{name}}', $UpdateJogador->getName(), $template);
            $template = str_replace('{{username}}', $UpdateJogador->getUsername(), $template);
            $template = str_replace('{{email}}', $UpdateJogador->getEmail(), $template);
            $template = str_replace('{{senha}}', $UpdateJogador->getSenha(), $template);
            $template = str_replace('{{createdata}}', $UpdateJogador->getCreatedata(), $template);
            echo $template;

            break;
         }