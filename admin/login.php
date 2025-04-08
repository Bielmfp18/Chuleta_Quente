<?php
include '../conn/connect.php';

if ($_POST) {
    $ident     = trim($_POST['login']);   // pode ser login, email ou CPF
    $senha     = $_POST['senha'];
    $senha_md5 = md5($senha);             // senha md5 para usuários

    if (!isset($_SESSION)) {
        session_name('chulettaaa');
        session_start();
    }

    // 1) Tenta usuário (tabela usuarios)
    $sqlU = "SELECT * FROM usuarios WHERE login = ? AND senha = ?";
    $stmt = $conn->prepare($sqlU);
    $stmt->bind_param("ss", $ident, $senha_md5);
    $stmt->execute();
    $res  = $stmt->get_result();

    if ($res->num_rows > 0) {
        $usuario = $res->fetch_assoc();
        $_SESSION['login_usuario'] = $usuario['login'];
        $_SESSION['nivel_usuario'] = $usuario['nivel'];
        $_SESSION['usuario_id']    = $usuario['id'];
        $_SESSION['nome_da_sessao']= session_name();

        if ($usuario['nivel'] == 'sup') {
            echo "<script>
                alert('Seja bem‑vindo, {$usuario['login']}!');
                window.location.href = '../admin/index.php';
            </script>";
            exit;
        }
        
    }

    // 2) Tenta cliente (tabela cliente + usuarios)
    $sqlC = "
      SELECT c.*, u.nivel
      FROM cliente c
      JOIN usuarios u ON u.id = c.usuario_id
      WHERE (c.email = ? OR c.cpf = ?) AND c.senha = ?
    ";
    $stmt = $conn->prepare($sqlC);
    $stmt->bind_param("sss", $ident, $ident, $senha); // senha simples
    $stmt->execute();
    $res  = $stmt->get_result();

    if ($res->num_rows > 0) {
        $cliente = $res->fetch_assoc();
        $_SESSION['login_usuario'] = $cliente['email'];
        $_SESSION['nivel_usuario'] = $cliente['nivel'];      // deve ser 'com'
        $_SESSION['usuario_id']    = $cliente['usuario_id'];
        $_SESSION['cliente_id']    = $cliente['id'];
        $_SESSION['cpf']           = $cliente['cpf'];        // <<< grava o CPF
        $_SESSION['nome_da_sessao']= session_name();

        echo "<script>
            alert('Seja bem‑vindo, {$cliente['nome']}!');
            window.location.href = '../cliente/index.php';
        </script>";
        exit;
    }

    // 3) Falha no login
    echo "<script>
        alert('Login ou senha inválidos.');
        window.location.href = 'login.php';
    </script>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="refresh" content="30;URL=../index.php">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chuleta Quente - Login</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://kit.fontawesome.com/2495680ceb.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/estilo.css" type="text/css">
</head>
<body>
<main class="container">
  <section>
    <article>
      <div class="row">
        <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
          <h1 class="breadcrumb text-info text-center">Faça seu login</h1>
          <div class="thumbnail">
            <p class="text-info text-center"><i class="fas fa-users fa-10x"></i></p>
            <br>
            <div class="alert alert-info">
              <form action="login.php" method="POST">
                <label for="login">Login (usuário, email ou CPF):</label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                  <input type="text" name="login" id="login" class="form-control" required autofocus placeholder="Digite seu login, email ou CPF">
                </div>
                <label for="senha">Senha:</label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                  <input type="password" name="senha" id="senha" class="form-control" required placeholder="Digite sua senha">
                </div>
                <div class="text-right" style="margin-top:10px;">
                  <button type="submit" class="btn btn-primary">Entrar</button>
                </div>
              </form>
              <br>
              <p class="text-center">
                                <small>
                                    Caso não faça uma escolha em 30 segundos será redirecionado automaticamente para página inicial.
                                </small>
                            </p>
            </div>
          </div>
        </div>
      </div>
    </article>
  </section>
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>
