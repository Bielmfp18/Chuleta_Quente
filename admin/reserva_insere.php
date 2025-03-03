<?php
include 'acesso_com.php';
include '../conn/connect.php';

//if ($_SERVER["REQUEST_METHOD"] == "POST") ->  Evita q a mensagem de erro apareça quando eu recarregar a página.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $cliente_id = $_POST['cliente_id']; 
    // $usuario_id = $_POST['usuario_id'];
    $data_horario= $_POST['data_horario'];
    $num_pessoas = $_POST['num_pessoas'];
    $motivo = $_POST['motivo'];
  

    try {
        // Tenta inserir o usuário no banco
        $reservaresult = $conn->query("INSERT INTO reserva VALUES (0, $cliente_id, $usuario_id, '$data_horario', $num_pessoas, '$motivo')");

        if ($reservaresult) {
            // Mensagem de sucesso ao inserir um novo usuário.
            echo "<script>
            alert('Novo reserva inserido com sucesso!');
            window.location.href='tipos_lista.php';
          </script>";
        } else {
            // Mensagem de erro apenas se houver falha na inserção do usuário.
            echo "<script>
            alert('Erro ao tentar inserir o novo reserva.');
            window.location.href='tipos_insere.php';
          </script>";
        }
        //Essa parte do código utiliza um método/função chamada getCode() da classe Exception (subclasse: mysqli_sql_exception)
        // que captura um erro e o mostra ao usuário em seu código de verificação (exemplo: Para entradas duplicadas no Banco de Dados -> Código 1062).
    } catch (mysqli_sql_exception $e) {
        // Captura erro de entrada duplicada (código 1062) e exibe uma mensagem de erro.
        if ($e->getCode() == 1062) {
            echo "<script>
            alert('Este reserva já está cadastrado!');
            window.location.href='tipos_insere.php';
          </script>";
        } else {
           echo "<script>
            alert('Erro ao tentar inserir o novo reserva. Tente novamente!');
            window.location.href='tipos_insere.php';
          </script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>reserva - Insere</title>
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
    <?php include "menu_adm.php"; ?>
    <main class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4"><!-- dimensionamento -->
            <h2 class="breadcrumb alert-warning">
                    <a href="tipos_lista.php" style = "text-decoration: none;">
                    <button class="btn btn-warning" type="button">
                            <span class="fas fa-chevron-left" aria-hidden="true"></span>
                        </button>
                    </a>
                    Inserindo reservas
                </h2>
                <div class="thumbnail" style = "padding : 7px; ">
                    <div class="alert alert-warning">
                        <form action="tipos_insere.php" name="form_insere_tipo" id="form_insere_tipo" method="POST" enctype="multipart/form-data">
                            <!-- input rotulo -->
                             
                            <label for="rotulo">Nome:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="rotulo" id="rotulo" autofocus maxlength="30" placeholder="Digite o rótulo." class="form-control" required autocomplete="off">
                            </div><!-- fecha input-group -->
                            <br>
                            <!-- fecha input rotulo -->

                            <!-- input sigla -->
                            <label for="sigla">Sigla:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="sigla" id="sigla" maxlength="8" placeholder="Digite a sigla desejada." class="form-control" required autocomplete="off">
                            </div><!-- fecha input-group -->
                            <br>
                            <!-- fecha input sigla_tipo -->


                            <!-- btn enviar -->
                            <input type="submit" value="Inserir" role="button" name="enviar" id="enviar" class="btn btn-block btn-warning" style = "background-color: #f0ad4e;">
                        </form>
                    </div><!-- fecha alert -->
                </div><!-- fecha thumbnail -->
            </div><!-- Fecha dimensionamento -->
        </div><!-- Fecha row -->
    </main>

    <!-- Link arquivos Bootstrap js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1
