<?php

include '../conn/connect.php';



//if ($_SERVER["REQUEST_METHOD"] == "POST") ->  Evita q a mensagem de erro apareça quando eu recarregar a página.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $nivel_usuario = $_POST['nivel'];
    // Tenta inserir o usuário no banco
    $loginresult = $conn->query("INSERT INTO usuarios VALUES (0, '$login', md5('$senha'), '$nivel_usuario')");
    
    $idresult = $conn->query("SELECT last_insert_id() as id_usuario");
    $iduser = $idresult->fetch_assoc();

    $id_usuario = $iduser['id_usuario'];

    $usuario_id = $_POST['usuario_id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
   // Tenta inserir o usuário no banco
        $loginresult = $conn->query("INSERT INTO cliente VALUES (0, '$usuario_id','$nome','$email','$cpf')");


    try {
     

        if ($loginresult) {
            // Mensagem de sucesso ao inserir um novo usuário.
            echo "<script>
            alert('Usuário inserido com sucesso!');
            window.location.href='cliente_lista.php';
          </script>";
        } else {
            // Mensagem de erro apenas se houver falha na inserção do usuário.
            echo "<script>
            alert('Erro ao tentar inserir o usuário.');
            window.location.href='cliente_insere.php';
          </script>";
        }
        //Essa parte do código utiliza um método/função chamada getCode() da classe Exception (subclasse: mysqli_sql_exception)
        // que captura um erro e o mostra ao usuário em seu código de verificação (exemplo: Para entradas duplicadas no Banco de Dados -> Código 1062).
    } catch (mysqli_sql_exception $e) {
        // Captura erro de entrada duplicada (código 1062) e exibe uma mensagem de erro.
        if ($e->getCode() == 1062) {
            echo "<script>
            alert('Este usuário já está cadastrado!');
            window.location.href='cliente_insere.php';
          </script>";
        } else {
            echo "<script>
            alert('Erro ao tentar inserir o usuário. Tente novamente!');
            window.location.href='cliente_insere.php';
          </script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Cliente - Insere</title>
    <meta charset="UTF-8">
    <!-- Link arquivos Bootstrap CSS -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- Link para CSS específico -->
    <link rel="stylesheet" href="../css/meu_estilo.css" type="text/css">

    <!-- Link para o Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <?php ;?>
    <main class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4"><!-- dimensionamento -->
                <h2 class="breadcrumb text-info">
                    <a href="cliente_lista.php">
                        <button class="btn btn-info" type="button">
                            <span class="fas fa-chevron-left" aria-hidden="true"></span>
                        </button>
                    </a>
                    Cadastro de Cliente
                </h2>
                <div class="thumbnail">
                    <div class="alert alert-info">
                        <form action="usuarios_insere.php" name="form_insere_usuario" id="form_insere_usuario" method="POST" enctype="multipart/form-data">
                            <!-- input login_usuario -->
                            <label for="login">Nome de Usuário:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="fas fa-user" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="login" id="login" autofocus maxlength="30" placeholder="Digite o nome de usuário." class="form-control" required autocomplete="off">
                            </div><!-- fecha input-group -->
                            <br>
                            <!-- fecha input login_usuario -->

                            <!-- input senha_usuario -->
                            <label for="senha">Senha:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="fas fa-lock" aria-hidden="true"></span>
                                </span>
                                <input type="password" name="senha" id="senha" maxlength="80" placeholder="Digite a senha." class="form-control" required autocomplete="off">
                            </div><!-- fecha input-group -->
                            <br>
                            <!-- fecha input senha_usuario -->
<hr>
                            <!-- radio nivel_usuario -->
                            <label class="hidden" for="nivel">Nível do usuário</label>
                            <div class="input-group">
                                <label class="hidden" for="nivel_c" class="radio-inline">
                                    <input type="radio" name="nivel" id="nivel" value="com" checked>Comum
                                </label>
                            </div><!-- fecha input-group -->
                        </form>
                        <br>
                        <!-- Fecha radio nivel_usuario -->

                        <form action="cadastro_cliente.php" name="form_insere_usuario" id="form_insere_usuario" method="POST" enctype="multipart/form-data">
                       
                            <!-- input login_usuario -->
                            <label for="login_usuario">Nome:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="fas fa-user" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="nome" id="login" autofocus maxlength="30" placeholder="Digite o nome de usuário." class="form-control" required autocomplete="off">
                            </div><!-- fecha input-group -->
                            <br>
                            <label for="login_email">Email:</label>
                            <p class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user text-info" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="email" id="login" class="form-control" autofocus required autocomplete="off" placeholder="Digite seu login.">
                            </p>

                            <br>

                            <label for="cpf">CPF:</label>
                            <p class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-edit text-info" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="cpf" id="cpf" maxlength="14"
                                    pattern="\d{3}\.\d{3}\.\d{3}-\d{2}"
                                    placeholder="000.000.000-00" required>
                            </p>
                            <br>
                            <!-- btn enviar -->
                            <input type="submit" value="Cadastrar" role="button" name="enviar" id="enviar" class="btn btn-block btn-info">
                        </form>
                    </div><!-- fecha alert -->
                </div><!-- fecha thumbnail -->
            </div><!-- Fecha dimensionamento -->
        </div><!-- Fecha row -->
    </main>

    <!-- Link arquivos Bootstrap js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1