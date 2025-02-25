<?php
include 'conn/connect.php';
$busca = $_GET['buscar'];
$lista_busca = $conn->query("SELECT * FROM vw_produtos where descricao like '%$busca%' or resumo like '%$busca%' order by descricao asc"); //se tiver a expressão no conteudo ele vai trazer
$linhaBusca = $lista_busca->fetch_assoc();
$numLinhas = $lista_busca->num_rows;
 
?>
 
<!DOCTYPE html>
<html lang="pt-br">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilo.css">
    <title>Busca por palavra</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
 
<body class="fundofixo">
    <?php include 'menu_publico.php'; ?>
    <div class="container">
        <!-- Mostrar se a consulta retornar vazio -->
        <?php if ($numLinhas == 0) { ?>
            <h2 class="breadcrumb alert-danger">
                <a href="javascript:window.history.go(-1)" class="btn btn-danger">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                Não há produtos relacionados com <strong>"<?php echo $busca ?>"</strong>
            </h2>
        <?php } ?>
        <!-- Mostrar se a consulta retornou produtos -->
        <?php if ($numLinhas > 0) { ?>
            <h2 class="breadcrumb alert-danger">
                <a href="javascript:window.history.go(-1)" class="btn btn-danger">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                Busca por <strong>"<?php echo $busca ?>"</strong>
            </h2>
            <div class="row">
                <?php do { ?>
                    <div class="col-sm-6 col-md-4">
                        <div class="thumbnail">
                            <a href="produto_detalhes.php?id=<?php echo $linhaBusca['id']; ?>">
                                <img src="images/<?php echo $linhaBusca['imagem']; ?>" class="img-responsive img-rounded">
                            </a>
                            <div class="caption text-right">
                                <h3 class="text-danger">
                                    <strong><?php echo $linhaBusca['descricao']; ?></strong>
                                </h3>
                                <p class="text-warning">
                                    <strong><?php echo $linhaBusca['rotulo']; ?></strong>
                                </p>
                                <p class="text-left">
                                    <?php echo mb_strimwidth($linhaBusca['resumo'], 0, 42, '...'); ?>
                                </p>
                                <p>
                                    <button class="btn btn-default disabled" role="button" style="cursor:default;">
                                        <?php echo "R$ ".number_format($linhaBusca['valor'],2,',','.'); ?>
                                    </button>
                                    <a href="produto_detalhes.php?id=<?php echo $linhaBusca['tipo_id']; ?>">
                                        <span class="hidden-xs">Saiba mais...</span>
                                        <span class="hidden-xs glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php } while ($linhaBusca = $lista_busca->fetch_assoc()); ?>
            </div>
        <?php } ?>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
