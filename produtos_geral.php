<?php 
include 'conn/connect.php';

// Executa a consulta no banco de dados
$lista = $conn->query('SELECT * FROM vw_produtos');
$num_linhas = $lista->num_rows;

// Se houver produtos, obtém o primeiro registro
$row_produtos = ($num_linhas > 0) ? $lista->fetch_assoc() : null;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Produtos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        .thumbnail img {
            max-height: 200px;
            width: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Exibe mensagem se não houver produtos -->
    <?php if ($num_linhas == 0) { ?>
        <h2 class="breadcrumb alert-danger text-center">
            Não há produtos cadastrados!
        </h2>
    <?php } else { ?>
        <h2 class="breadcrumb alert-success text-center">
            Produtos Disponíveis
        </h2>

        <div class="row">
            <?php $count = 0; ?>
            <?php do { ?>
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <a href="produto_detalhes.php?id=<?php echo $row_produtos['id']; ?>">
                            <img src="images/<?php echo $row_produtos['imagem']; ?>" alt="Imagem de <?php echo $row_produtos['descricao']; ?>" class="img-responsive img-rounded">
                        </a>
                        <div class="caption text-right bg-success">
                            <h3 class="text-danger">
                                <strong><?php echo $row_produtos['descricao']; ?></strong>
                            </h3>
                            <p class="text-warning">
                                <strong><?php echo $row_produtos['rotulo']; ?></strong>
                            </p>
                            <p class="text-left">
                                <?php echo mb_strimwidth($row_produtos['resumo'], 0, 42, '...'); ?>
                            </p>
                            <p>
                                <button class="btn btn-default disabled" role="button" style="cursor: default;">
                                    <?php echo "R$ " . number_format($row_produtos['valor'], 2, ',', '.'); ?>
                                </button>
                                <a href="produto_detalhes.php?id=<?php echo $row_produtos['id']; ?>" class="btn btn-info">
                                    <span class="hidden-xs">Saiba mais..</span>
                                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <?php 
                $count++;
                if ($count % 3 == 0) { 
                    echo '<div class="clearfix visible-md visible-lg"></div>'; //Isso que ajuda ao site ficar com os produtos alinhados.
                }
                ?>

            <?php } while ($row_produtos = $lista->fetch_assoc()); ?>
        </div>
    <?php } ?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
