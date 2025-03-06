<?php
include '../admin/menu_adm.php';
include '../conn/connect.php';

// $pdo->beginTransaction();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Dados do usuário
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $nivel_usuario = $_POST['nivel'];

    // Insere o usuário na tabela "usuarios"
    $loginresult = $conn->query("INSERT INTO usuarios VALUES (0, '$login', md5('$senha'), '$nivel_usuario')");

    if ($loginresult) {
        // Recupera o ID do usuário inserido
        $idresult = $conn->query("SELECT LAST_INSERT_ID() as id_usuario");
        $iduser = $idresult->fetch_assoc();
        $id_usuario = $iduser['id_usuario'];

        // Dados do cliente
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];
        $senha = $_POST['senha'];

        // Insere o cliente na tabela "cliente" usando o id do usuário
        $clienteResult = $conn->query("INSERT INTO cliente VALUES (0, '$id_usuario', '$nome', '$email', '$cpf', '$senha')");

        if ($clienteResult) {
            echo "<script>
                alert('Cliente cadastrado com sucesso!');
                window.location.href='cliente_lista.php';
              </script>";
        } else {
            echo "<script>
                alert('Erro ao tentar cadastrar o cliente.');
                window.location.href='cliente_insere.php';
              </script>";
        }
    } else {
        echo "<script>
            alert('Erro ao tentar cadastrar o cliente.');
            window.location.href='cliente_insere.php';
          </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Cliente - Insere</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/meu_estilo.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <main class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4">
                <h2 class="breadcrumb text-success">
                    <a href="cliente_lista.php" style = "text-decoration: none;">
                        <button class="btn btn-success" type="button">
                            <span class="fas fa-chevron-left" aria-hidden="true"></span>
                        </button>
                    </a>
                    Cadastro de Cliente
                </h2>
                <div class="thumbnail">
                    <div class="alert alert-success">
                        <form action="cliente_insere.php" method="POST" name="form_insere_usuario" id="form_insere_usuario">
                            <label for="login">Nome de Usuário:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="fas fa-user text-success" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="login" id="login" autofocus maxlength="100" placeholder="Digite o nome de usuário." class="form-control" required autocomplete="off">
                            </div>
                            <br>
                            <label for="senha">Senha:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="fas fa-lock text-success" aria-hidden="true"></span>
                                </span>
                                <input type="password" name="senha" id="senha" maxlength="80" placeholder="Digite a senha." class="form-control" required autocomplete="off">
                            </div>
<br>
                             <!-- radio nivel_usuario -->
                             <label for="nivel">Nível do usuário</label>
                            <div class="input-group">
                                <label for="nivel_c" class="radio-inline">
                                    <input type="radio" name="nivel" id="nivel" value="com" checked>Comum
                                </label>
                            </div><!-- fecha input-group -->
                            <br>
                            <!-- Fecha radio nivel_usuario -->


                          
                            <label for="nome">Nome:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="fas fa-user text-success" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="nome" id="nome" maxlength="100" placeholder="Digite o nome do cliente." class="form-control" autocomplete="off" required >
                            </div>
                            <br>
                            <label for="email">Email:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="fas fa-envelope text-success" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="email" id="email" class="form-control" required autocomplete="on" placeholder="Digite o email.">
                            </div>
                            <br>
                            <label for="cpf">CPF:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="fas fa-id-card text-success" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="cpf" id="cpf" maxlength="14" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" placeholder="000.000.000-00" required>
                            </div>
                            <br>
                                <!-- input senha_cliente -->
                                <label for="senha">Senha:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="fas fa-lock text-success" aria-hidden="true"></span>
                                </span>
                                <input type="password" name="senha" id="senha" maxlength="80" placeholder="Digite a senha." class="form-control" autocomplete="off" required>
                            </div><!-- fecha input-group -->
                            <br>
                            <!-- fecha input senha_cliente -->
                                 <input type="submit" value="Cadastrar" role="button" name="enviar" id="enviar"  class="btn btn-block btn-success">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
