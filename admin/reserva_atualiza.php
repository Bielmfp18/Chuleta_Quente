<?php
include 'acesso_com.php';
include '../conn/connect.php';

// Seleciona os dados do reserva atual para exibição no formulário.
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql_row = $conn->query("SELECT * FROM reserva WHERE id = $id");
    $row = $sql_row->fetch_assoc();
 }// else {
//     echo  var_dump($row);
// }

// Processa o formulário ao ser submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados enviados pelo formulário
    $id = $_GET['id'];
    $cliente_nome = $_POST['nome'];
    $cliente_cpf = $_POST['cpf'];
    $cliente_email = $_POST['email'];
    $data = $_POST['data'];
    $horario = $_POST['horario'];
    $num_pessoas = $_POST['num_pessoas'];
    $motivo = $_POST['motivo'];


    // Monta a query especificando os campos
    $sql = $conn->query("UPDATE reserva SET cliente_nome = '$cliente_nome', cliente_cpf = '$cliente_cpf', cliente_email = '$cliente_email', data = '$data', horario = '$horario', num_pessoas = '$num_pessoas', motivo = '$motivo' WHERE id = $id");


    // Executa a query e, se houver erro, lança uma exceção com a mensagem do MySQL

    // Executa a query e faz o tratamento de erro ou sucesso
    if ($sql) {
        echo "<script>
                alert('Reserva atualizada com sucesso!');
                window.location.href='reserva_lista.php';
              </script>";
    } else {
        echo "<script>
                alert('Erro ao tentar atualizar a reserva. Erro: " . $conn->error . "');
                window.location.href='reserva_atualiza.php?id=$id';
              </script>";
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
                <a href="reserva_lista.php" style="text-decoration: none;">
                    <h2 class="breadcrumb alert-primary">
                        <a href="reserva_lista.php" style="text-decoration: none;">
                            <button class="btn btn-primary" type="button">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            </button>
                        </a>
                        Atualizando Reserva
                    </h2>
                    <!-- Action vazia para postar para o próprio arquivo -->
                    <form action="reserva_atualiza.php?id=<?php echo $row['id']; ?>" method="POST" enctype="multipart/form-data" name="form_atualiza_reserva" id="form_atualiza_reserva">

                        <!-- Campo nome -->
                        <div class="thumbnail">
                            <div class="alert alert-primary">
                                <label for="nome">Nome Completo:</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user text-info" aria-hidden="true"></span>
                                    </span>
                                    <input type="text" name="nome" value="<?php echo $row['cliente_nome']; ?>" id="nome" autofocus maxlength="100" placeholder="Digite o nome completo" class="form-control" required autocomplete="on">
                               
                                </div>
                                <br>

                                <!-- Campo CPF -->
                                <label for="cpf">CPF:</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-edit text-info" aria-hidden="true"></span>
                                    </span>
                                    <input
                                        type="text"
                                        name="cpf"
                                        value="<?php echo $row['cliente_cpf']; ?>"
                                        id="cpf"
                                        maxlength="14"
                                        pattern="[0-9]{3}\.[0-9]{3}\.[0-9]{3}-[0-9]{2}"
                                        placeholder="000.000.000-00"
                                        class="form-control"
                                        required>

                                </div>
                                <br>
                                <!-- Campo Email -->
                                <label for="email">Email:</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                                    </span>
                                    <input type="text" name="email" value="<?php echo $row['cliente_email']; ?>" id="email" maxlength="300" placeholder="Digite seu email." class="form-control" required autocomplete="off">
                                </div>
                                <br>
                                <!-- Campo Data -->
                                <label for="data">Data:</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                                    </span>
                                    <input type="date" name="data"  value="<?php echo date('Y-m-d'); ?>"  id="data" class="form-control" required autocomplete="off">
                                </div>
                                <br>
                                <!-- Campo Horário -->
                                <label for="horario">Horário:</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                                    </span>
                                    <input type="time" name="horario" id="horario" value="<?php echo $row['horario']; ?>" class="form-control" required autocomplete="off">
                                </div>
                                <br>
                                <!-- Número de Pessoas -->
                                <label for="num_pessoas">Número de Pessoas:</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                    </span>
                                    <input type="number" name="num_pessoas" id="num_pessoas" value="<?php echo $row['num_pessoas']; ?>" min="1" max="99" class="form-control" required>
                                </div>
                                <br>
                                <!-- Campo Motivo -->
                                <label for="motivo">Motivo:</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                                    </span>
                                    <textarea name="motivo" id="motivo"  value="<?php echo $row['motivo']; ?>"  placeholder='Digite seu motivo (Ex: "Casamento", "Aniversário", etc.)'class="form-control" required autocomplete="on"></textarea>
                                </div>
                                <br>
                                <!-- Campo Status oculto (1 = ativo) -->
                                <input type="hidden" name="status" id="status" value="1">
                                <!-- Botão Enviar -->
                                <input type="submit" value="Atualizar" role="button" name="enviar" id="enviar" class="btn btn-block btn-primary">
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