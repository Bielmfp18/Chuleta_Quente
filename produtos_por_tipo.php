<?php
include 'conn/connect.php';
$idTipo = $_GET['id_tipo'];
$rotulo = $_GET['rotulo'];
$listaPorTipo = $conn->query("SELECT * FROM vw_produtos where tipo_id = $idTipo AND rotulo = '$rotulo'"); //se tiver a expressão no conteúdo ele vai trazer
$rowPorTipo = $listaPorTipo->fetch_assoc();
$numLinhas = $listaPorTipo->num_rows;
?>

<!DOCTYPE html>
<html lang="pt-br">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <!-- Font Awesome para ícones modernos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <link rel="stylesheet" href="css/estilo.css">
    <title>Busca por palavra</title>
</head>

<body class="fundofixo">
    <?php include 'menu_publico.php'; ?>

    <div class="container">
        <!-- Exibir mensagem se não houver produtos -->
        <?php if ($numLinhas == 0) { ?>
            <h2 class="breadcrumb alert-danger">
                <a href="javascript:window.history.go(-1)" class="btn btn-danger">
                    <i class="fa fa-chevron-left"></i> <!-- Ícone corrigido -->
                </a>
                Não há produtos relacionados com <strong> "<?php echo $rotulo ?>"</strong>
            </h2>
        <?php } ?>

        <!-- Exibir produtos se houver resultados -->
        <?php if ($numLinhas > 0) { ?>
            <h2 class="breadcrumb alert-danger">
                <a href="javascript:window.history.go(-1)" class="btn btn-danger">
                    <i class="fa fa-chevron-left"></i> <!-- Ícone corrigido -->
                </a>
                Busca por <strong>"<?php echo $rotulo ?>"</strong>
            </h2>

            <div class="row">
            <?php $count = 0; ?>
                <?php do { ?>
                    <div class="col-sm-6 col-md-4">
                        <div class="thumbnail">
                            <a href="produto_detalhes.php?id=<?php echo $rowPorTipo['id']; ?>">
                                <img src="images/<?php echo $rowPorTipo['imagem']; ?>" class="img-responsive img-rounded">
                            </a>
                            <div class="caption text-right">
                                <h3 class="text-danger">
                                    <strong><?php echo $rowPorTipo['descricao']; ?></strong>
                                </h3>
                                <p class="text-warning">
                                    <strong><?php echo $rowPorTipo['rotulo']; ?></strong>
                                </p>
                                <p class="text-left">
                                    <?php echo mb_strimwidth($rowPorTipo['resumo'], 0, 42, '...') ?>
                                </p>
                                <p>
                                    <button class="btn btn-default disabled" role="button" style="cursor:default;">
                                        <?php echo "R$ " . number_format($rowPorTipo['valor'], 2, ',', '.'); ?>
                                    </button>
                                    <a href="produto_detalhes.php?id=<?php echo $rowPorTipo['id']; ?>">
                                        <span class="hidden-xs">Saiba mais...</span>
                                        <i class="fa fa-eye"></i> <!-- Ícone corrigido -->
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
                <?php } while ($rowPorTipo = $listaPorTipo->fetch_assoc()) ?>
            </div>
        <?php } ?>
    </div>

    <!-- jQuery e Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Slick (caso esteja usando carrossel) -->
    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).on('ready', function() {
            $(".regular").slick({
                dots: true,
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 3
            });
        });
    </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>

</body>

</html>
