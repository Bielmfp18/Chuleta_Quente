<?php
include 'acesso_com.php';
include '../conn/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados enviados pelo formulário
    $cliente_nome = $_POST['nome'];
    $cliente_cpf   = $_POST['cpf'];
    $cliente_email = $_POST['email'];
    $data          = $_POST['data'];
    $horario       = $_POST['horario'];
    $num_pessoas   = $_POST['num_pessoas'];
    $motivo        = $_POST['motivo'];
    $status        = $_POST['status']; // Deve ser 1 para reserva ativa

    // Monta a query especificando os campos (boa prática para evitar problemas com a ordem dos campos)
    $sql = "INSERT INTO reserva (id, cliente_nome, cliente_cpf, cliente_email, data, horario, num_pessoas, motivo, ativo) 
            VALUES (0, '$cliente_nome', '$cliente_cpf', '$cliente_email', '$data', '$horario', $num_pessoas, '$motivo', $status)";

    try {
        // Executa a query e, se houver erro, lança uma exceção com a mensagem do MySQL
        if (!$conn->query($sql)) {
            throw new mysqli_sql_exception($conn->error, $conn->errno);
        }

        echo "<script>
                alert('Nova reserva inserida com sucesso!');
                window.location.href='reserva_lista.php';
              </script>";
    } catch (mysqli_sql_exception $e) {
        // Se o erro for de duplicidade (código 1062), exibe a mensagem correspondente
        if ($e->getCode() == 1062) {
            echo "<script>
                    alert('Esta reserva já está cadastrada!');
                    window.location.href='index.php';
                  </script>";
        } else {
            // Exibe o erro real para ajudar na depuração
            echo "<script>
                    alert('Erro ao tentar inserir a nova reserva. Erro: " . $e->getMessage() . "');
                    window.location.href='index.php';
                  </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Área de Cliente - Chuleta Quente</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap e CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilo.css" type="text/css">
</head>

<body>
    <?php include "menu_adm.php"; ?>

    <main class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4">
            <h2 class="breadcrumb alert-primary">
                        <a href="reserva_lista.php" style="text-decoration: none;">
                            <button class="btn btn-primary" type="button">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            </button>
                        </a>
                       Inserindo Reserva
                    </h2>
                        <!-- Action vazia para postar para o próprio arquivo -->
                        <form action="reserva_insere.php" name="form_insere_reserva" id="form_insere_reserva" method="POST" enctype="multipart/form-data">
              
                        

                            
                            <!-- Número de Pessoas -->
                            <label for="num_pessoas">Número de Pessoas:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                </span>
                                <input type="number" name="num_pessoas" id="num_pessoas" value="1" min="1" max="99" class="form-control" required>
                            </div>
                 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts do Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>