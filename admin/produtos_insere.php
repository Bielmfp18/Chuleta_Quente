<?php
include 'acesso_com.php';
include '../conn/connect.php';

// Verifica se o formulário foi enviado via POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo_id = $_POST['tipo_id']; // Recebe o tipo_id do formulário
    $descricao = $_POST['descricao'];
    $resumo = $_POST['resumo'];
    $valor = $_POST['valor'];
    $destaque = $_POST['destaque'] === 'sim' ? 'sim' : 'nao';

    // Verifica se a imagem foi enviada corretamente
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $imagem = $_FILES['imagem']['name'];
        $imagem_temp = $_FILES['imagem']['tmp_name'];
        $imagem_destino = '../images/' . $imagem;
        
        // Move o arquivo para o diretório desejado
        move_uploaded_file($imagem_temp, $imagem_destino);
    } else {
        $imagem = ''; // Caso não haja imagem
    }

    // Tenta inserir o produto no banco de dados
    $sql = $conn->query("INSERT INTO produtos VALUES (0, '$tipo_id', '$descricao', '$resumo', '$valor', '$imagem', '$destaque')");

    // Verifica se a inserção foi bem-sucedida
    if ($sql) {
        echo "<script>
        alert('Produto inserido com sucesso!');
        window.location.href='produtos_lista.php';
      </script>";
    } else {
        echo "<script>
        alert('Erro ao tentar inserir o produto.');
        window.location.href='produtos_insere.php';
      </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Produtos - Inserir</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/meu_estilo.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <?php include "menu_adm.php"; ?>
    <main class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4">
            <h2  class="thumbnail alert-danger" style = "padding: 10px;">
                    <a href="produtos_lista.php">
                    <button class="btn btn-alert-danger" type="button"  style="background-color: #d9534f; color: white;">
                            <span class="fas fa-chevron-left" aria-hidden="true"></span>
                        </button>
                    </a>
                   Inserindo Produto
                </h2>
                <div class="thumbnail" style="padding: 7px;">
                <div class="alert alert-danger" role="alert">
                        <form action="produtos_insere.php" method="POST" enctype="multipart/form-data">
                            
                                <!-- Campo para o tipo de produto -->
                                <label for="tipo_id">Tipo de Produto</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-tags" aria-hidden="true"></span>
                                </span>
                                <select name="tipo_id" id="tipo_id" class="form-control" required>
                                    <option value="1">Churrasco</option>
                                    <option value="2">Sobremesa</option>
                                    <option value="3">Bebida</option>
                                </select>
                            </div>
                            <br>

                            <!-- Campo para o nome do produto -->
                            <label for="descricao">Produto</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="descricao" id="descricao" maxlength="30" placeholder="Digite o nome do produto" class="form-control" required autocomplete="off">
                            </div>
                            <br>

                            <!-- Campo para o resumo -->
                            <label for="resumo">Resumo</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="resumo" id="resumo" maxlength="300" placeholder="Digite o resumo" class="form-control" required autocomplete="off">
                            </div>
                            <br>

                            <!-- Campo para o valor -->
                            <label for="valor">Valor</label>
                            <div class="input-group">
                                <span class="input-group-addon" >
                                    <span class="glyphicon glyphicon-usd" aria-hidden="true"></span>
                                </span>
                                <input type="number" name="valor" id="valor" maxlength="8" placeholder="0.00" class="form-control" required autocomplete="off" step="0.01" min="0">
                            </div>
                            <br>

                            <!-- Campo para a imagem -->
                            <label for="imagem">Imagem</label>
                            <div class="input-group" style="align-items: center; justify-content: flex-start; gap: 40px;">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
                                </span>
                                <label for="imagem" style="background-color: #d9534f;  color: white; border: none; padding: 10px 15px; cursor: pointer;">Escolher Imagem</label>
                                <input type="file" name="imagem" id="imagem" class="form-control" required style="display: none;">
                            </div>
                            <br>

                            <!-- Campo para o destaque -->
                            <label for="destaque">Destaque</label>
                            <div class="input-group" style="align-items: center; justify-content: flex-start; gap: 20px;">
                                <!-- <span class="input-group-addon">
                                    <span class="	glyphicon glyphicon-star" aria-hidden="true"></span>
                                </span> -->
                                <div style="display: flex; gap: 10px;">
                                    <label>
                                        <input type="radio" name="destaque" value="sim" required style = "accent-color:#d9534f;"> Sim
                                    </label>
                                    <label>
                                        <input type="radio" name="destaque" value="nao" required style = "accent-color:#d9534f;"> Não
                                    </label>
                                </div>
                            </div>
                            <br>

                            <!-- Botão de submissão -->
                            <input type="submit" value="Inserir" role="button" name="enviar" id="enviar" class="btn btn-block btn-danger" style="background-color: #d9534f;  color: white; border: none; padding: 10px 15px; cursor: pointer;">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>
