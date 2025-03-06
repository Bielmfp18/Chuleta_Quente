<?php
include 'acesso_com.php';
include '../conn/connect.php';

// Busca as informações dos usuários no Banco de Dados.
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql_usuarios = $conn->query("SELECT * FROM usuarios WHERE id = $id");
    $usuarios = $sql_usuarios->fetch_assoc();
}

// Verifica se o formulário foi enviado via POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verifica se o ID foi passado na URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $login = $_POST['login'];
        $senha = $_POST['senha'];
        $nivel = $_POST['nivel_usuario'];

        try {
            // Tenta atualizar o usuário no banco de dados
            $sql = $conn->query("UPDATE usuarios SET login = '$login', senha = md5('$senha'), nivel = '$nivel' WHERE id = $id");

            // Verifica se a atualização foi bem-sucedida
            if ($sql) {
                // Mensagem de sucesso
                echo "<script>
                    alert('Usuário atualizado com sucesso!');
                    window.location.href='usuarios_lista.php';
                  </script>";
            } else {
                // Mensagem de erro
                echo "<script>
                    alert('Erro ao tentar atualizar o usuário.');
                    window.location.href='usuarios_atualiza.php';
                  </script>";
            }
        } catch (mysqli_sql_exception $e) {
            // Captura erro de entrada duplicada (código 1062) e exibe uma mensagem de erro.
            if ($e->getCode() == 1062) {
                echo "<script>
                    alert('Este Usuário já está cadastrado!');
                    window.location.href='usuarios_lista.php';
                  </script>";
            } else {
                echo "<script>
                    alert('Erro ao tentar atualizar o usuário. Tente novamente!');
                    window.location.href='usuarios_lista.php';
                  </script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Usuários - Atualizar</title>
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
                    <a href="usuarios_lista.php" style = "text-decoration: none;">
                        <button class="btn btn-info" type="button">
                            <span class="fas fa-chevron-left" aria-hidden="true"></span>
                        </button>
                    </a>
                    Atualizando Usuário
                </h2>
                <div class="thumbnail">
                    <div class="alert alert-info">
                        <!-- Formulário para atualização de usuário -->
                        <form action="usuarios_atualiza.php<?php echo isset($_GET['id']) ? '?id=' . $_GET['id'] : ''; ?>" method="POST" name="form_atualiza_usuario" id="form_atualiza_usuario">
                            <label for="login">Login:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="fas fa-user" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="login" value="<?php echo $usuarios['login']; ?>" id="login" maxlength="80" placeholder="Digite o seu login" class="form-control" required autocomplete="off">
                            </div>
                            <br>

                            <label for="senha">Senha:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="fas fa-lock" aria-hidden="true"></span>
                                </span>
                                <input type="password" name="senha" value="" id="senha" maxlength="80" placeholder="Digite a senha desejada" class="form-control" required autocomplete="off" autocomplete="new-password">
                            </div>
                            <br>

                            <label for="nivel">Nível do usuário</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="fas fa-user-cog" aria-hidden="true"></span> <!-- Ícone fixo de user cog -->
                                </span>
                                <select name="nivel_usuario" id="nivel_usuario" class="form-control" required>
                                    <option value="com" <?php echo $usuarios['nivel'] == 'com' ? 'selected' : ''; ?>>Comum</option>
                                    <option value="sup" <?php echo $usuarios['nivel'] == 'sup' ? 'selected' : ''; ?>>Supervisor</option>
                                </select>
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