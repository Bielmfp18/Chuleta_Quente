<?php
include 'acesso_com.php';
include "../conn/connect.php";


$lista = $conn->query("SELECT * FROM cliente order by nome "); //Vai organizar os logins começando pelo nome.
$row = $lista->fetch_assoc();
$numrow = $lista->num_rows;

?>
<!-- html:5 -->
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Chuleta Quente - Cliente</title>
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
    <h1 class="breadcrumb alert-success">Lista de Clientes</h1>

        <div class="col-xs-12 col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4"><!-- dimensionamento -->
            <table class="table table-hover table-condensed tbopacidade">
                <thead>

                    <tr>
                        <th class="hidden">ID</th>
                        <th class="hidden">USUÁRIO_ID</th>
                        <th>NOME</th>
                        <th>EMAIL</th>
                        <th>CPF</th>
                        <th>
                            <a href="cliente_insere.php" target="_self" class="btn btn-block btn-primary btn-xs" role="button">
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
                            <td class="hidden"> <?php echo $row['id_usuario']; ?></td>
                            <td><?php echo isset($row['nome']) ? $row['nome'] : "Sem nome"; ?></td>
                            <td><?php echo isset($row['email']) ? $row['email'] : "Sem email"; ?></td>
                            <td><?php echo isset($row['cpf']) ? $row['cpf'] : "Sem cpf"; ?></td>

                            <td><a href="cliente_atualiza.php?id=<?php echo $row['id'];?>" class="btn btn-block btn-warning btn-sm"> <!-- btn-block -->
                                    <span class="hidden-xs">ALTERAR <br></span>
                                    <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                                </a>
                                <button data-nome="<?php echo $row['nome'];?>" data-id="<?php echo $row['id'];?>" class="delete btn btn-block btn-danger  btn-sm"> <!-- btn-block -->
                                    <span class="hidden-xs">EXCLUIR <br></span>
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
            var nome = $(this).data('nome');
            // buscar o valor do atributo data-nome
            var id = $(this).data('id');
            // buscar o valor do atributo data-id
            $('span.nome').text(nome);
            // Inserir o nome do item na pergunta de confirmação
            $('a.delete-yes').attr('href', 'cliente_exclui.php?id='+id);
            // mandar dinamicamente o id do link no botão confirmar
            $('#myModal').modal('show'); // Modal abre
        });
    </script>

</body>

</html>