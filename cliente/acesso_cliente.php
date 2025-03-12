<?php
// Se não houver uma sessão iniciada, inicia a sessão com o nome definido.
if (!isset($_SESSION)) {
    //Sempre coloque o session_name antes de um session_start.
    session_name('chulettaaa');
    session_start();
}

// Verifica se o usuário está logado, usando a variável 'login_cliente'
if (!isset($_SESSION['login_cliente'])) {
      //Se não existir, redirecionamos para login a sessão por segurança
    header('location: login_cliente.php');
    exit;
}

// Valida se o nome da sessão armazenado confere com o nome atual da sessão.
$nome_da_sessao = session_name();
if (!isset($_SESSION['nome_da_sessao']) or $_SESSION['nome_da_sessao'] !== $nome_da_sessao) {
    // Se houver divergência, destrói a sessão e redireciona para o login.
    session_destroy();
    session_unset();
    header('location: login_cliente.php');
    exit;
}
?>
