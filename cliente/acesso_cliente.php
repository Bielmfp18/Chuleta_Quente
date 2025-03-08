<?php
// Se não houver uma sessão iniciada, inicia a sessão com o nome definido.
if (!isset($_SESSION)) {
    session_name('chulettaaa');
    session_start();
}

// Verifica se o usuário está logado através da variável 'email_cliente'
if (!isset($_SESSION['email_cliente'])) {
    // Se não estiver logado, redireciona para a página de login.
    header('Location: login_cliente.php');
    exit;
}

// Valida se o nome da sessão armazenado confere com o nome atual da sessão.
$nome_da_sessao = session_name();
if (!isset($_SESSION['nome_da_sessao']) || $_SESSION['nome_da_sessao'] !== $nome_da_sessao) {
    // Se houver divergência, destrói a sessão e redireciona para o login.
    session_destroy();
    session_unset();
    header('Location: login_cliente.php');
    exit;
}
?>
