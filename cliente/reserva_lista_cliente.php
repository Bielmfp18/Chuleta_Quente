<?php
include '../cliente/acesso_cliente.php';
include "../conn/connect.php";

// Garante que a sessão esteja iniciada e utiliza o CPF definido na sessão.
$clientecpf = isset($_SESSION['cpf']) ? $_SESSION['cpf'] : '';

if (empty($clientecpf)) {
    echo "<p class='alert alert-danger'>CPF não encontrado. Faça login novamente.</p>";
    exit;
}

// Para exibir apenas as reservas que possuem o CPF do cliente,
// utilize a condição de igualdade no SQL.
$lista = $conn->query("SELECT * FROM reserva WHERE cliente_cpf LIKE '%$clientecpf%'");
$numrow = $lista->num_rows;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Chuleta Quente - Reserva</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilo.css" type="text/css">
</head>

<body>
    <?php include "menu_adm_cliente.php"; ?>
    <main class="container">
        <h1 class="breadcrumb alert-primary">Minhas Reservas</h1>

        <div class="table-responsive container-centralizado">
            <table class="table table-hover table-condensed tbopacidade text-center">
                <thead>
                    <tr>
                    <th class="hidden">ID</th>
                        <th class="text-center">NOME</th>
                        <th class="text-center">CPF</th>
                        <th class="text-center">EMAIL</th>
                        <th class="text-center">DATA</th>
                        <th class="text-center">HORÁRIO</th>
                        <th class="text-center">NÚMERO DE PESSOAS</th>
                        <th class="text-center">MOTIVO</th>
                        <th class="hidden">STATUS</th>
                        <th>
                        <th>
                            <a href="reserva_insere.php" target="_self" class="btn btn-primary btn-block btn-xs" role="button">
                                <span class="hidden-xs">FAZER MAIS UMA RESERVA <br></span>
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $lista->fetch_assoc()) { ?>
                        <tr>
                            <td class="hidden"> <?php echo $row['id']; ?></td>
                            <td> <?php echo isset($row['cliente_nome']) ? $row['cliente_nome'] : "Sem nome"; ?></td>
                            <td> <?php echo isset($row['cliente_cpf']) ? $row['cliente_cpf'] : "Sem CPF"; ?></td>
                            <td><?php echo isset($row['cliente_email']) ? $row['cliente_email'] : "Sem email"; ?></td>
                            <td><?php echo isset($row['data']) ? $row['data'] : "Sem data"; ?></td>
                            <td><?php echo isset($row['horario']) ? $row['horario'] : "Sem horário"; ?></td>
                            <td><?php echo isset($row['num_pessoas']) ? $row['num_pessoas'] : "Sem número de pessoas"; ?></td>
                            <td><?php echo isset($row['motivo']) ? $row['motivo'] : "Sem motivo"; ?></td>
                            <td class="hidden"> <?php echo isset($row['status']) ? $row['status'] : "Sem status"; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>