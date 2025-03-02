<?php
include '../conn/connect.php';
include 'acesso_com.php';

// Busca as informações do cliente no Banco de Dados.
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql_cliente = $conn->query("SELECT * FROM cliente WHERE id = $id");
    $cliente = $sql_cliente->fetch_assoc();
}
// Busca as informações dos usuários no Banco de Dados.
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql_usuarios = $conn->query("SELECT * FROM usuarios WHERE id = $id");
    $usuarios = $sql_usuarios->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Dados do usuário
    $iduser = $_GET['id'];
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $nivel_usuario = $_POST['nivel_usuario'];

    // Insere o usuário na tabela "usuarios"
    $loginresult = $conn->query("UPDATE usuarios SET login = '$login', senha = md5('$senha'), nivel = '$nivel_usuario' WHERE id = $iduser");

    if ($loginresult) {
        // Recupera o ID do usuário inserido
        $idresult = $conn->query("SELECT LAST_INSERT_ID() as id_usuario");
        $iduser = $idresult->fetch_assoc();
        $id_usuario = $iduser['id_usuario'];

        // Dados do cliente
        $idcliente = $_GET['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];

        // Insere o cliente na tabela "cliente" usando o id do usuário
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
    } else {
        echo "<script>
            alert('Erro ao tentar atualizaro cliente.');
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
                <h2 class="breadcrumb text-info">
                    <a href="cliente_lista.php">
                        <button class="btn btn-info" type="button">
                            <span class="fas fa-chevron-left" aria-hidden="true"></span>
                        </button>
                    </a>
                    Atualizando Cliente
                </h2>
                <div class="thumbnail">
                    <div class="alert alert-info">
                        <!-- Formulário para atualização de usuário -->
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
                                <input type="password" name="senha" value="" id="senha" maxlength="80" placeholder="Digite a nova senha" class="form-control" required autocomplete="off" autocomplete="new-password">
                            </div>
                            <br>

                          
                            <!-- radio nivel_usuario -->
                            <label  for="nivel">Nível do usuário</label>
                            <div class="input-group">
                                <label for="nivel_c" class="radio-inline">
                                    <input type="radio" name="nivel" id="nivel" value="com" checked>Comum
                                </label>
                            </div><!-- fecha input-group -->

                   
                            <br>
                            <!-- Dados do Cliente -->
                            <label for="nome">Nome:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="fas fa-user" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="nome" id="nome" value = "<?php echo $cliente['nome'];?>" maxlength="80" placeholder="Digite o nome do cliente." class="form-control" required autocomplete="off">
                            </div>
                            <br>
                            <label for="email">Email:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user text-info" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="email" id="email" value = "<?php echo $cliente['email'];?>" class="form-control" required autocomplete="off" placeholder="Digite o email.">
                            </div>
                            <br>
                            <label for="cpf">CPF:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-edit text-info" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="cpf" id="cpf" value = "<?php echo $cliente['cpf']; ?>" maxlength="14" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" placeholder="000.000.000-00" required>
                            </div>
                            <br>
                            <input type="submit" value="Atualizar" role="button" name="enviar" id="enviar" class="btn btn-block btn-info">
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