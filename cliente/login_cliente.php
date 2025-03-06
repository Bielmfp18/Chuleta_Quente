<?php
include '../conn/connect.php';
//Inicia a verificação do login.
if ($_POST) {
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];
    // echo base64_encode();
    $loginresult = $conn->query("SELECT * FROM cliente WHERE email = '$email' AND  cpf = '$cpf' AND senha = '$senha'");
    $rowLogin = $loginresult->fetch_assoc();
    // var_dump($rowLogin);
    // die();
    $sessionAntiga = session_name('chulettaaa');
    $numRow = $loginresult->num_rows;
    if (!isset($_SESSION)) {
        $session_name_new = session_name();
        session_start();
    }
    if ($numRow > 0) {
        $_SESSION['login_cliente'] = $rowLogin['email'];
        $_SESSION['cpf_cliente'] = $rowLogin['cpf'];
        $_SESSION['nome_da_sessao'] = session_name();
        if ($rowLogin['email'] == $email &&  $rowLogin['cpf'] == $cpf && $rowLogin['senha']){
            echo "<script>window.open('index.php', '_self')</script>"; // echo "<script>window.open('index.php', '_blank')</script>"; abre a janela diministrativa em uma outra aba.
        } else {
            echo "<script>window.open('index.php?cliente=" . $email . "','_self')</script>"; //self carrega a página na mesma aba.
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="30;URL=../index.php">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/2495680ceb.js" crossorigin="anonymous"></script>
    <!-- Link para CSS específico -->
    <link rel="stylesheet" href="../css/estilo.css" type="text/css">

    <title>Chuleta Quente - Login</title>
</head>

<body>
    <main class="container">
        <section>
            <article>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                        <h1 class="breadcrumb text-info text-center">Faça seu login</h1>
                        <div class="thumbnail">
                            <p class="text-info text-center" role="alert">
                                <i class="fas fa-users fa-10x"></i>
                            </p>
                            <br>
                            <div class="alert alert-info" role="alert">
                                <form action="login_cliente.php" name="form_email" id="form_email" method="POST" enctype="multipart/form-data">
                                    <label for="login_email">Email:</label>
                                    <p class="input-group">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-user text-info" aria-hidden="true"></span>
                                        </span>
                                        <input type="text" name="email" id="email" class="form-control" autofocus required autocomplete="off" placeholder="Digite seu email.">
                                    </p>
                                  
                                    <label for="cpf">CPF:</label>
                                    <p class="input-group">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-edit text-info" aria-hidden="true"></span>
                                        </span>
                                        <input type="text" name="cpf" id="cpf" maxlength="14"
                                            pattern="\d{3}\.\d{3}\.\d{3}-\d{2}"
                                            placeholder="000.000.000-00" class="form-control" required>
                                    </p>
                                    
                                    <label for="senha">Senha:</label>
                                    <p class="input-group">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-lock text-info" aria-hidden="true"></span>
                                        </span>
                                        <input type="password" name="senha" id="senha" class="form-control" required autocomplete="off" placeholder="Digite sua senha.">
                                    </p>
                                    <br>
                                    <p class="text-right">
                                        <input type="submit" value="Entrar" class="btn btn-primary">
                                    </p>
                                </form>
                                <p class="text-center">
                                    <small>
                                        <br>
                                        Caso não faça uma escolha em 30 segundos será redirecionado automaticamente para página inicial.
                                    </small>
                                </p>
                                <br><br>
                                <p class="text-center">
                                    <small>
                                        <br>
                                       Não está cadastrado?. <a href="cadastro_cliente.php">Clique Aqui</a>
                                    </small>
                                </p>
                            </div><!-- fecha alert -->
                        </div><!-- fecha thumbnail -->
                    </div><!-- fecha dimensionamento -->
                </div><!-- fecha row -->
            </article>
        </section>
    </main>


    <!-- Link arquivos Bootstrap js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>