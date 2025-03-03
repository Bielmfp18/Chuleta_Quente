<?php 
//Inicia uma sessão.
session_start();
//Unset, recebe a super global $_SESSION com o valor do usuário que deseja logar e destrói a sessão.
unset($_SESSION['login_usuario']);

//Exibe a mensagem de desconexão após o logout e redireciona a página de login.
echo "<script>
            alert('Você se desconectou da sua conta!');
            window.location.href='login.php';
        </script>";
?>

