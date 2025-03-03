<?php
include '../conn/connect.php';
include 'acesso_com.php';

// Busca as informações do cliente no Banco de Dados.
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql_cliente = $conn->query("SELECT * FROM cliente WHERE id = $id");
    $cliente = $sql_cliente->fetch_assoc();
}
// Busca as informações do usuário no Banco de Dados.
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql_usuarios = $conn->query("SELECT * FROM usuarios WHERE id = $id");
    $usuarios = $sql_usuarios->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_GET['id'];  
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];

    $id_usuario = $_GET['id']; 
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $nivel_usuario = $_POST['nivel'];

    $loginresult = $conn->query("UPDATE usuarios SET login = '$login', senha = md5('$senha'), nivel = '$nivel_usuario' WHERE id = $id_usuario");
    $clienteResult = $conn->query("UPDATE cliente SET usuario_id = '$id_usuario', nome = '$nome', email = '$email', cpf ='$cpf' WHERE id = $id");

    if ($clienteResult) {
        echo "<script>
            alert('Cliente atualizado com sucesso!');
            window.location.href='../admin/cliente_lista.php';
        </script>";
    } else {
        echo "<script>
            alert('Erro ao tentar atualizar o cliente.');
            window.location.href='cliente_atualiza.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Cliente - Atualizar</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/meu_estilo.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <?php include "menu_adm.php"; ?>
    <main class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4">
                <h2 class="breadcrumb text-success">
                    <a href="cliente_lista.php" style = "text-decoration: none;">
                        <button class="btn btn-success" type="button">
                            <span class="fas fa-chevron-left" aria-hidden="true"></span>
                        </button>
                    </a>
                    Atualizando Cliente
                </h2>
                <div class="thumbnail">
                    <div class="alert alert-success">
                        <form action="cliente_atualiza.php<?php echo isset($_GET['id']) ? '?id=' . $_GET['id'] : ''; ?>" method="POST" name="form_atualiza_usuario" id="form_atualiza_usuario">
                            <label for="login">Nome de Usuário:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="fas fa-user" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="login" value="<?php echo $usuarios['login']; ?>" id="login" maxlength="80" placeholder="Digite o novo login" class="form-control" required autocomplete="on">
                            </div>
                            <br>

                            <label for="senha">Senha:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="fas fa-lock" aria-hidden="true"></span>
                                </span>
                                <input type="password" name="senha" value="" id="senha" maxlength="80" placeholder="Digite a nova senha" class="form-control" required autocomplete="off">
                            </div>
                            <br>

                            <label for="nivel">Nível do usuário</label>
                            <div class="input-group">
                                <label for="nivel_c" class="radio-inline">
                                    <input type="radio" name="nivel" id="nivel" value="com" checked>Comum
                                </label>
                            </div>
                            <br>

                            <label for="nome">Nome:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="fas fa-user" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="nome" id="nome" value="<?php echo $cliente['nome']; ?>" maxlength="80" placeholder="Digite o nome do cliente." class="form-control" required autocomplete="off">
                            </div>
                            <br>

                            <label for="email">Email:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                <span class="fas fa-envelope text-success" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="email" id="email" value="<?php echo $cliente['email']; ?>" class="form-control" required autocomplete="off" placeholder="Digite o email.">
                            </div>
                            <br>

                            <label for="cpf">CPF:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-edit text-success" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="cpf" id="cpf" value="<?php echo $cliente['cpf']; ?>" maxlength="14" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" placeholder="000.000.000-00" required>
                            </div>
                            <br>

                            <input type="submit" value="Atualizar" role="button" name="enviar" id="enviar" class="btn btn-block btn-success">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
