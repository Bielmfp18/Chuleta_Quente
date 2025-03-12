<?php
include '../admin/acesso_com.php';
include '../conn/connect.php';

// Valida o ID enviado por GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql_row = $conn->query("SELECT * FROM reserva WHERE id = $id");
    if ($sql_row && $sql_row->num_rows > 0) {
        $row = $sql_row->fetch_assoc();
    } else {
        die("Reserva não encontrada.");
    }
} else {
    die("ID inválido.");
}

// Processa o formulário via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados enviados pelo formulário
    $id = intval($_GET['id']);
    $num_mesa = intval($_POST['num_mesa']);

    // Atualiza a reserva (define o número da mesa e ativa a reserva)
    $sql = $conn->query("UPDATE reserva SET num_mesa = $num_mesa, ativo = 1 WHERE id = $id");

    if ($sql) {
        echo "<script>
            alert('Reserva confirmada com sucesso!');
            window.location.href='reserva_lista.php';
          </script>";
    } else {
        echo "<script>
            alert('Erro ao confirmar a reserva.');
            window.location.href='reserva_lista.php';
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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .container4 {
            height: 100%;
            padding-top: 130px;
        }
    </style>
</head>
<body>
    <?php include '../admin/menu_adm.php'; ?>
    <main class="container4">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4">
                <div class="panel panel-info">
                    <div class="panel-heading" style="text-align: center;">
                        <h2 class="breadcrumb alert-secondary">
                            <a href="reserva_lista.php" style="text-decoration: none;">
                                <button class="btn btn-primary" type="button" style="margin-right: 10px;">
                                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                </button>
                            </a>
                            Regras para Pedido de Reserva
                        </h2>
                    </div>
                    <div class="panel-body" style="text-align:center; font-size:20px;">
                        <p>Adicione um número de mesa para confirmar esta reserva.</p>
                    </div>
                    <div class="panel-footer text-center">
                        <form action="reserva_aceita.php?id=<?php echo $row['id']; ?>" method="POST" enctype="multipart/form-data" name="form_atualiza_reserva">
                            <div class="form-group">
                                <label for="num_mesa" style="font-size:20px;">Número da Mesa:</label>
                                <div class="input-group" style="width:150px; margin:10px auto;">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                                    </span>
                                    <input type="number" name="num_mesa" id="num_mesa" value="1" min="1" max="99" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top:30px;">
                                <input type="submit" value="Confirmar Reserva" role="button" name="enviar" id="enviar" class="btn btn-primary btn-block" style="height: 33px;">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Bootstrap js -->
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
