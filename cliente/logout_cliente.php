<?php 
session_start();
// Remove a variável de sessão correta
unset($_SESSION['login_cliente']);

// Opcional: destrói toda a sessão para garantir que nada fique salvo
session_destroy();

echo "<script>
        alert('Você se desconectou da sua conta!');
        window.location.href='../index.php';
      </script>";
?>
