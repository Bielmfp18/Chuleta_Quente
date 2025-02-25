<?php
include 'acesso_com.php';
include "../conn/connect.php";

$lista = $conn->query("SELECT * FROM produtos ORDER BY descricao "); // Organizar os produtos pela descrição.
$row = $lista->fetch_assoc();
$numrow = $lista->num_rows;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Chuleta Quente - Produtos</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilo.css" type="text/css">

</head>

<body>
    <?php include "menu_adm.php"; ?>

    <main class="container">

        <h1 class="breadcrumb alert-warning">Lista de Produtos</h1>

        <div class="table-responsive container-centralizado"><!-- dimensionamento -->
        <table class="table table-hover table-condensed tbopacidade text-center">
                <thead>
                    <tr>
                        <th class="hidden">ID</th>
                        <th class="hidden">TIPO_ID</th>
                        <th>DESCRIÇÃO</th>
                        <th class="text-center">RESUMO</th>
                        <th>VALOR</th>
                        <th class="text-center">IMAGEM</th>
                        <th>
                            <a href="produtos_insere.php" target="_self" class="btn btn-block btn-primary btn-xs" role="button">
                                <span class="hidden-xs">ADICIONAR <br></span>
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a>

                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php do { ?>
                            <tr>
                                <td class="hidden"> <?php echo $row['id']; ?></td>
                                <td><?php echo isset($row['descricao']) ? $row['descricao'] : "Sem descrição"; ?></td>
                                <td><?php echo isset($row['resumo']) ? $row['resumo'] : "Sem resumo"; ?></td>
                                <td><?php echo isset($row['valor']) ? "R$ " . number_format($row['valor'], 2, ',', '.') : "Não informado"; ?></td>
                                <td>
                                    <?php if (!empty($row['imagem'])) { ?>
                                        <img src="../images/<?php echo $row['imagem']; ?>" alt="Imagem do Produto" width="100">
                                    <?php } else { ?>
                                        Sem imagem
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="produtos_atualiza.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">ALTERAR
                                    <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                                    </a>
                                    <button data-nome="<?php echo $row['descricao']; ?>" data-id="<?php echo $row['id']; ?>" class="delete btn btn-danger btn-sm">EXCLUIR
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                    </button>
                                </td>
                            </tr>
                        <?php } while ($row = $lista->fetch_assoc());?>
                        <!-- Fecha a estrutura de repetição -->
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
        Deseja mesmo EXCLUIR o item?
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
var descricao = $(this).data('descricao');
// buscar o valor do atributo data-nome
var id = $(this).data('id');
// buscar o valor do atributo data-id
$('span.nome').text(descricao);
// Inserir o nome do item na pergunta de confirmação
$('a.delete-yes').attr('href', 'produtos_exclui.php?id='+id);
// mandar dinamicamente o id do link no botão confirmar
$('#myModal').modal('show'); // Modal abre
});
</script>

</body>

</html>