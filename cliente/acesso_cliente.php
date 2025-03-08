<?php
//Se não tiver nenhum valor atribuído é porque não há nenhuma sessão aberta.//->Significado de if(!isset($_SESSION))
if (!isset($_SESSION)) {
    //Sempre coloque o session_name antes de um session_start.
    session_name('chulettaaa');
    session_start();
}

//Segurança Digital
//Verificar se o usuário está logado na sessão.
//  $_SESSION['login_usuario']="aluno";
if (!isset($_SESSION['login_cliente'])) {
    //Se não existir, redirecionamos para login a sessão por segurança
    header('location: login_cliente.php'); //Redirecionamento
    exit;
}

//Se houver uma ação de invasão por acesso não permitido à página pós-login, ele irá destruir a session.
$nome_da_sessao = session_name();
if (!isset($_SESSION['nome_da_sessao']) || $_SESSION['nome_da_sessao'] !== $nome_da_sessao) {
    session_destroy();
    session_unset(); // Remove todas as variáveis da sessão
    header('location: login_cliente.php');
    exit;
}
?>
