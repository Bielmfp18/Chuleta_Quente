<?php
include 'acesso_com.php';
include '../conn/connect.php';

// Verifica se o formulário foi enviado via POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verifica se o ID foi passado na URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $descricao = $_POST['descricao'];
        $resumo = $_POST['resumo'];
        $valor = $_POST['valor'];
        $imagem = $_POST['imagem'];
        $tipo_id = $_GET['tipo_id'];
        $destaque = $_POST['destaque'];


        // Tenta atualizar o usuário no banco de dados
        $sql = $conn->query("UPDATE produtos SET  descricao = '$descricao', resumo = '$resumo', valor = '$valor', imagem = '$imagem', tipo_id = '$tipo_id', destaque = '$destaque' WHERE id = $id");

        // Verifica se a atualização foi bem-sucedida
        if ($sql) {
            // Mensagem de sucesso
            echo "<script>
            alert('Produto atualizado com sucesso!');
            window.location.href='produtos_lista.php';
          </script>";
        } else {
            // Mensagem de erro
            echo "<script>
            alert('Erro ao tentar atualizar o produto.');
            window.location.href='produtos_atualiza.php';
          </script>";
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $destaque = $_POST['destaque'] ?? 'nao';

            if ($destaque === 'sim') {
            } else {
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Produtos - Atualizar</title>
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
                <h2 class="breadcrumb text-info">
                    <a href="produtos_lista.php">
                        <button class="btn btn-info" type="button">
                            <span class="fas fa-chevron-left" aria-hidden="true"></span>
                        </button>
                    </a>
                    Atualizando Produto
                </h2>
                <div class="thumbnail">
                    <div class="alert alert-info">
                        <form action="produtos_atualiza.php?id=<?php echo $_GET['id']; ?>" method="POST" name="form_atualiza_produto" id="form_atualiza_produto">
                            <label for="atualizar_produto">Produto</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="rotulo" id="rotulo" maxlength="30" placeholder="Digite o nome" class="form-control" required autocomplete="off">
                            </div>
                            <br>

                            <label for="resumo">Resumo</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="resumo" id="resumo" maxlength="80" placeholder="Digite o resumo" class="form-control" required autocomplete="off">
                            </div>
                            <br>
                            <label for="valor">Valor</label>
                            <div class="input-group">
                                <span class="input-group-addon" >
                                    <span class="glyphicon glyphicon-usd" aria-hidden="true"></span>
                                </span>
                                <input type="number" name="valor" id="valor" maxlength="8" placeholder="0.00" class="form-control" required autocomplete="off" step="0.01" min="0">
                            </div>
                            <br>


                            <form action="imagens_produto.php" method="post" enctype="multipart/form-data">
                                <label for="imagem">Imagem</label>
                                <div class="input-group" style=" align-items: center; justify-content: flex-start; gap: 40px;">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
                                    </span>
                                    <label for="imagem" style="background-color: #5bc0de; color: white; border: none; padding: 10px 15px;  cursor: pointer; ">Escolher Imagem</label>
                                    <input type="file" name="imagem" id="imagem" maxlength="80" class="form-control" required autocomplete="off" style="display: none;"> <!--O "display: none" retira o botão enviar arquivo sem o CSS-->
                                </div>
                            </form>

                        </form>
                        <br>
                        <form action="adicionar_produto.php" method="post">
                            <label for="destaque">Destaque</label>
                            <div class="input-group" style=" align-items: center; justify-content: flex-start; gap: 20px;">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                                </span>
                                <div style="display: flex; gap: 10px;">
                                    <label>
                                        <input type="radio" name="destaque" value="sim" required> Sim
                                    </label>
                                    <label>
                                        <input type="radio" name="destaque" value="nao" required> Não
                                    </label>
                                </div>
                            </div>
                            <br>
                        </form>


                        <input type="submit" value="Atualizar" role="button" name="enviar" id="enviar" class="btn btn-block btn-info">
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