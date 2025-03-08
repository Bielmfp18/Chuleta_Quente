<?php
include 'acesso_com.php';
include "../conn/connect.php";

//Pega os valores através da Super Global GET e não deixa espaços em branco com o método trim.
$cpf = isset($_GET['cpf']) ? trim($_GET['cpf']) : '';
$data = isset($_GET['data']) ? trim($_GET['data']) : '';
$status = isset($_GET['status']) ? trim($_GET['status']) : ''; // Alterado para "status" para combinar com o form

$sql = "SELECT * FROM reserva WHERE 1=1 "; // Garante que os filtros funcionem corretamente

$lista = $conn->query("SELECT * FROM reserva "); //Vai organizar as reservas.
$row = $lista->fetch_assoc();
$numrow = $lista->num_rows;

if (!empty($cpf)) {
    //trás a busca com uma "continuação" do sql em $lista.
    $sql .= " AND cliente_cpf LIKE '%$cpf%'";
}

if (!empty($data)) {
    $sql .= " AND data = '$data'";
}

if ($status !== '') {  // Alterado para permitir o valor "0"
    $sql .= " AND ativo = '$status'";
}

// Executa a consulta após adicionar os filtros
$lista = $conn->query($sql);
$row = $lista->fetch_assoc();
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
    <?php include "menu_adm.php"; ?>
    <main class="container">
        <h1 class="breadcrumb alert-primary">Lista de Reservas</h1>
        <!-- FORMULÁRIO DO FILTRO -->
        <div class="container text-center">
            <form action="" method="GET" class="form-inline" style="margin-bottom: 50px;">
                <div class="form-group">
                    <label for="cpf">CPF:</label>
                    <input type="text" name="cpf" id="cpf" class="form-control" placeholder="Digite o CPF para busca">
                </div>

                <div class="form-group" style="margin-left: 10px;">
                    <label for="data">DATA:</label>
                    <input type="date" name="data" id="data" class="form-control" placeholder="dd/mm/aaaa">
                </div>

                <div class="form-group" style="margin-left: 10px;">
                    <label for="status">STATUS:</label>
                    <select name="status" id="status" class="form-control" style="height: 34px;">
                        <option value="">TUDO</option>
                        <option value="1" <?php if ($status === '1') echo 'selected'; ?>>ATIVAS</option>
                        <option value="0" <?php if ($status === '0') echo 'selected'; ?>>DESATIVAS</option>
                    </select>

                </div>

                <button type="submit" class="btn btn-success" style="margin-left: 10px;">Filtrar</button>
             
            </form>

            <!-- FIM DO FORMULÁRIO DE FILTRO -->
        </div>
        <div class="table-responsive container-centralizado"><!-- dimensionamento -->
            <table class="table table-hover table-condensed tbopacidade text-center">
                <thead>

                    <tr>
                        <th class="hidden">ID</th>
                        <th class="text-center">CLIENTE_CPF</th>
                        <th class="text-center">CLIENTE_EMAIL</th>
                        <th class="text-center">DATA</th>
                        <th class="text-center">HORÁRIO</th>
                        <th class="text-center">NÚMERO DE PESSOAS</th>
                        <th class="text-center">MOTIVO</th>
                        <th class="text-center">STATUS</th>
                        <th>
                            <a href="reserva_insere.php" target="_self" class="btn btn-primary btn-block btn-xs"  role="button">
                                <span class="hidden-xs">ADICIONAR <br></span>
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- estrutura de repetição -->
                    <?php do { ?>

                        <tr>
                            <td class="hidden"> <?php echo $row['id']; ?></td>
                            <td> <?php echo isset($row['cliente_cpf']) ? $row['cliente_cpf'] : "Sem CPF"; ?></td>
                            <td><?php echo isset($row['cliente_email']) ? $row['cliente_email'] : "Sem email"; ?></td>
                            <td><?php echo isset($row['data']) ? $row['data'] : "Sem data"; ?></td>
                            <td><?php echo isset($row['horario']) ? $row['horario'] : "Sem horario"; ?></td>
                            <td><?php echo isset($row['num_pessoas']) ? $row['num_pessoas'] : "Sem um número de pessoas"; ?></td>
                            <td><?php echo isset($row['num_mesa']) ? $row['num_mesa'] : "Sem um número da mesa"; ?></td>
                            <td><?php echo isset($row['motivo']) ? $row['motivo'] : "Sem motivo"; ?></td>
                            <td class="text-center">
                                <?php echo (isset($row['ativo']) ? (($row['ativo'] == 1) ? "Ativo" : "Desativo") : "Sem status"); ?>
                            </td>

                            <td>
                     
                            <a href="reserva_aceita.php?id=<?php echo $row['id']; ?>" target="_self" class="btn btn-block btn-success btn-xs" role="button">
                                <span class="hidden-xs">ACEITAR <br></span>
                                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                            </a>
            
                                <a href="reserva_atualiza.php?id=<?php echo $row['id']; ?>" class="btn btn-block btn-warning btn-sm"> <!-- btn-block -->
                                    <span class="hidden-xs">ALTERAR <br></span>
                                    <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                                </a>
                                <button data-nome="" data-id="<?php echo $row['id']; ?>" class="delete btn btn-block btn-danger  btn-sm"> <!-- btn-block -->
                                    <span class="hidden-xs">REJEITAR<br></span>
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </button>
                            </td>
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
                    Deseja mesmo REJEITAR está reserva?
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
            // buscar o valor do atributo data-nome
            var id = $(this).data('id');
            // buscar o valor do atributo data-id
            $('span.nome').text(nome);
            // Inserir o nome do item na pergunta de confirmação
            $('a.delete-yes').attr('href', 'reserva_desativa.php?id=' + id);
            // mandar dinamicamente o id do link no botão confirmar
            $('#myModal').modal('show'); // Modal abre
        });
    </script>

</body>

</html>