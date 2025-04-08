<?php
include '../conn/connect.php';
include 'acesso_com.php';

// Busca as informações do cliente no Banco de Dados.
if (isset($_GET['id'])) {
    $id_cliente = (int) $_GET['id'];

    // Busca dados do cliente
    $sql_cliente = $conn->prepare("SELECT * FROM cliente WHERE id = ?");
    $sql_cliente->bind_param("i", $id_cliente);
    $sql_cliente->execute();
    $cliente = $sql_cliente->get_result()->fetch_assoc();
    $sql_cliente->close();

    // Agora que temos $cliente['usuario_id'], buscamos o usuário correto
    $id_usuario = (int) $cliente['usuario_id'];
    $sql_usuarios = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
    $sql_usuarios->bind_param("i", $id_usuario);
    $sql_usuarios->execute();
    $usuarios = $sql_usuarios->get_result()->fetch_assoc();
    $sql_usuarios->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cliente   = (int) $_GET['id'];
    $id_usuario   = (int) $cliente['usuario_id'];
    $nome         = $_POST['nome'];
    $email        = $_POST['email'];
    $cpf          = $_POST['cpf'];
    $login        = $_POST['login'];
    $senha_plain  = $_POST['senha'];
    $senha_md5    = md5($senha_plain);
    $nivel_usuario= $_POST['nivel'];

    // Atualiza tabela usuarios
    $upd_user = $conn->prepare("
        UPDATE usuarios
        SET login = ?, senha = ?, nivel = ?
        WHERE id = ?
    ");
    $upd_user->bind_param("sssi", $login, $senha_md5, $nivel_usuario, $id_usuario);
    $ok_user = $upd_user->execute();
    $upd_user->close();

    // Atualiza tabela cliente
    $upd_cli = $conn->prepare("
        UPDATE cliente
        SET usuario_id = ?, nome = ?, email = ?, cpf = ?, senha = ?
        WHERE id = ?
    ");
    $upd_cli->bind_param("issssi", $id_usuario, $nome, $email, $cpf, $senha_md5, $id_cliente);
    $ok_cli = $upd_cli->execute();
    $upd_cli->close();

    if ($ok_user && $ok_cli) {
        echo "<script>
            alert('Cliente atualizado com sucesso!');
            window.location.href='../admin/cliente_lista.php';
        </script>";
    } else {
        echo "<script>
            alert('Erro ao tentar atualizar o cliente.');
            window.location.href='cliente_atualiza.php?id={$id_cliente}';
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
                    <a href="cliente_lista.php" style="text-decoration: none;">
                        <button class="btn btn-success" type="button">
                            <span class="fas fa-chevron-left" aria-hidden="true"></span>
                        </button>
                    </a>
                    Atualizando Cliente
                </h2>
                <div class="thumbnail">
                    <div class="alert alert-success">
                        <form action="cliente_atualiza.php?id=<?php echo $id_cliente; ?>" method="POST" name="form_atualiza_usuario" id="form_atualiza_usuario">
                            <!-- Nome de Usuário -->
                            <label for="login">Nome de Usuário:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="fas fa-user" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="login" maxlength="80" placeholder="Digite o novo login" class="form-control" value="<?php echo htmlspecialchars($usuarios['login']); ?>" required>
                            </div>
                            <br>

                            <!-- Senha de Usuário -->
                            <label for="senha">Senha:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="fas fa-lock" aria-hidden="true"></span>
                                </span>
                                <input type="password" name="senha" id="senha" maxlength="80" placeholder="Digite a nova senha" class="form-control" required>
                            </div>
                            <br>

                            <!-- Nível do usuário -->
                            <label for="nivel">Nível do usuário</label>
                            <div class="input-group">
                                <label class="radio-inline">
                                    <input type="radio" name="nivel" value="com" <?php if($usuarios['nivel']==='com') echo 'checked'; ?>>Comum
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="nivel" value="sup" <?php if($usuarios['nivel']==='sup') echo 'checked'; ?>>Supervisor
                                </label>
                            </div>
                            <br>

                            <!-- Nome do Cliente -->
                            <label for="nome">Nome:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="fas fa-user" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($cliente['nome']); ?>" maxlength="80" placeholder="Digite o nome do cliente." class="form-control" required>
                            </div>
                            <br>

                            <!-- Email do Cliente -->
                            <label for="email">Email:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="fas fa-envelope text-success" aria-hidden="true"></span>
                                </span>
                                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($cliente['email']); ?>" class="form-control" required>
                            </div>
                            <br>

                            <!-- CPF do Cliente -->
                            <label for="cpf">CPF:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-edit text-success" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="cpf" id="cpf" value="<?php echo htmlspecialchars($cliente['cpf']); ?>" maxlength="14" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" placeholder="000.000.000-00" class="form-control" required>
                            </div>
                            <br>

                            <!-- Botão de Enviar -->
                            <input type="submit" value="Atualizar" class="btn btn-block btn-success">
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
