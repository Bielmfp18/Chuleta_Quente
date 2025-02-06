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
<body class = "fundofixo">
    <!-- Área de menu -->
     <?php include 'menu_publico.php'; ?>
     <a name="home">&nbsp;</a>
     <main class="container">
    <!-- Área de Carrossel -->
     <?php include 'carrossel.php';?>
     <!-- Área de Destaque -->
      <a class="pt-6" name = "destaques">&nbsp;</a>
      <?php include 'produtos_destque.php';?>
     <!--Área geral de produtos -->
     <a class="pt-6" name = "produtos">&nbsp;</a>
     <!-- "include" pega todas as informações do arquivo e o adiciona ao local declarado no código html -->
     <?php include 'produtos_geral.php';?>
     <!--  Rodapé -->
       <footer class="panel-footer"></footer>
       <?php include 'rodape.php';?>
       <a name="contato"></a>
    </main>
</body>
</html>