<?php
include 'acesso_cliente.php';
include "../conn/connect.php";

// Se existir GET de 'filtro', mudamos a ordem da consulta conforme o valor
if(isset($_GET['filtro']) && !empty($_GET['filtro'])){
    $filtro = $_GET['filtro'];
    if($filtro == 'cpf'){
        $sql = "SELECT * FROM reserva WHERE ativo = 1 ORDER BY cliente_cpf";
    } elseif($filtro == 'data'){
        $sql = "SELECT * FROM reserva WHERE ativo = 1 ORDER BY data";
    } elseif($filtro == 'status'){
        $sql = "SELECT * FROM reserva WHERE ativo = 1 ORDER BY status";
    } else {
        $sql = "SELECT * FROM reserva WHERE ativo = 1 ORDER BY id";
    }
} else {
    // Caso não tenha filtro selecionado, usa a consulta padrão
    $sql = "SELECT * FROM reserva WHERE ativo = 1 ORDER BY id";
}

$lista = $conn->query($sql);
$row   = $lista->fetch_assoc();
$numrow = $lista->num_rows;
?>
<!-- html:5 -->
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Chuleta Quente - Reserva</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link arquivos Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- Link para CSS específico -->
    <link rel="stylesheet" href="../css/estilo.css" type="text/css">
</head>

<body class="">
    <?php include "menu_adm_cliente.php"; ?>
    <main class="container">
        <h1 class="breadcrumb alert-primary">Lista de Reservas</h1>

        <div class="table-responsive container-centralizado"><!-- dimensionamento -->
            <table class="table table-hover table-condensed tbopacidade text-center">
                <thead>
                    <tr>
                        <th class="hidden">ID</th>
                        <th class="text-center">CLIENTE_CPF</th>
                        <th class="text-center">CLIENTE_EMAIL</th>
                        <th class="text-center">DATA</th>
                        <th class="text-center">HORÁRIO</th>
                        <th class="text-center">MOTIVO</th>
                        <th class="hidden">STATUS</th>
                        <th>
                            <?php function filtrar(){} ?>
                            <!-- Formulário de filtro integrado no cabeçalho -->
                            <form action="lista_reservas_cliente.php" method="GET" class="form-inline">
                                <select name="filtro" id="filtro" class="form-control" required>
                                    <option value="" disabled selected>FILTRO</option>
                                    <!-- Ajuste para manter o valor selecionado após submit -->
                                    <option value="cpf"    <?php echo (isset($_GET['filtro']) && $_GET['filtro'] == 'cpf')    ? 'selected' : ''; ?>>CPF</option>
                                    <option value="data"   <?php echo (isset($_GET['filtro']) && $_GET['filtro'] == 'data')   ? 'selected' : ''; ?>>Data</option>
                                    <option value="status" <?php echo (isset($_GET['filtro']) && $_GET['filtro'] == 'status') ? 'selected' : ''; ?>>Status</option>
                                </select>
                            </form>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- estrutura de repetição -->
                    <?php do { ?>
                        <tr>
                            <td class="hidden"><?php echo $row['id']; ?></td>
                            <td><?php echo isset($row['cliente_cpf']) ? $row['cliente_cpf'] : "Sem CPF"; ?></td>
                            <td><?php echo isset($row['cliente_email']) ? $row['cliente_email'] : "Sem email"; ?></td>
                            <td><?php echo isset($row['data']) ? $row['data'] : "Sem data"; ?></td>
                            <td><?php echo isset($row['horario']) ? $row['horario'] : "Sem horario"; ?></td>
                            <td><?php echo isset($row['motivo']) ? $row['motivo'] : "Sem motivo"; ?></td>
                            <td class="hidden"><?php echo isset($row['status']) ? $row['status'] : "Sem status"; ?></td>
                            <td></td>
                        </tr>
                    <?php } while ($row = $lista->fetch_assoc()); ?>
                    <!-- fecha estrutura de repetição -->
                </tbody>
            </table>
        </div><!-- fecha dimensionamento -->
    </main>

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                    <h4 class="modal-title text-danger">ATENÇÃO!</h4>
                </div><!-- fecha modal-header -->
                <div class="modal-body">
                    Deseja mesmo DESATIVAR está reserva?
                    <h4><span class="nome text-danger"></span></h4>
                </div><!-- fecha modal-body -->
                <div class="modal-footer">
                    <a href="#" type="button" class="btn btn-danger delete-yes">
                        Confirmar
                    </a>
                    <button class="btn btn-success" data-dismiss="modal">
                        Cancelar
                    </button>
                </div><!-- fecha modal-footer -->
            </div><!-- fecha modal-content -->
        </div><!-- Fecha modal-dialog -->
    </div><!-- Fecha Modal -->

    <!-- Link arquivos Bootstrap js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

    <!-- Script para o Modal -->
    <script type="text/javascript">
        $('.delete').on('click', function() {
            var nome = $(this).data('nome');
            var id   = $(this).data('id');
            $('span.nome').text(nome);
            $('a.delete-yes').attr('href', 'reserva_desativa.php?id=' + id);
            $('#myModal').modal('show');
        });
    </script>

</body>
</html>
