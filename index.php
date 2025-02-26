<?php



?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <!-- "Viewport" define o tamanho da tela quando a página for aberta. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilo.css">
    <title>Chuleta Quente Churrascaria</title>
</head>

<body class="fundofixo">
    <!-- Área de menu -->
    <?php include 'menu_publico.php'; ?>
    <a name="home">&nbsp;</a>
    <main class="container">
        <!-- Área de Carrossel -->
        <?php include 'carrossel.php'; ?>
        <!-- Área de Destaque -->
        <a class="pt-6" name="destaques">&nbsp;</a>
        <?php include 'produtos_destaque.php'; ?>
        <!--Área geral de produtos -->
        <a class="pt-6" name="produtos">&nbsp;</a>
        <!-- "include" pega todas as informações do arquivo e o adiciona ao local declarado no código html -->
        <?php include 'produtos_geral.php'; ?>
   
        <!--  Rodapé -->
        <footer class="panel-footer"></footer>
        <?php include 'rodape.php'; ?>
        <a name="contato"></a>
    </main>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).on('ready', function() {
        $(".regular").slick({
            dots: true,
            infinity: true,
            slidesToShow: 3,
            slidesToScroll: 3
        });

    });
</script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick.min.js"></script>

</html>