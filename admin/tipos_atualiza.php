<?php
include 'acesso_com.php';
include '../conn/connect.php';

//Pega os dados do tipo no Banco de Dados.
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql_tipos = $conn->query("SELECT * FROM tipos WHERE id = $id");
    $tipos = $sql_tipos->fetch_assoc();
}


// Verifica se o formulário foi enviado via POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verifica se o ID foi passado na URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sigla = $_POST['sigla'];
        $rotulo = $_POST['rotulo'];


        // Tenta atualizar o usuário no banco de dados
        $sql = $conn->query("UPDATE tipos SET sigla = '$sigla', rotulo = '$rotulo' WHERE id = $id");

        // Verifica se a atualização foi bem-sucedida
        if ($sql) {
            // Mensagem de sucesso
            echo "<script>
            alert('Tipo atualizado com sucesso!');
            window.location.href='tipos_lista.php';
          </script>";
        } else {
            // Mensagem de erro
            echo "<script>
            alert('Erro ao tentar atualizar o tipo.');
            window.location.href='tipos_atualiza.php';
          </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Tipos - Atualizar</title>
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
                <h2 class="breadcrumb alert-warning">
                    <a href="tipos_lista.php" style = "text-decoration: none;">
                        <button class="btn btn-warning" type="button">
                            <span class="fas fa-chevron-left" aria-hidden="true"></span>
                        </button>
                    </a>
                    Atualizando Tipo
                </h2>
                <div class="thumbnail" style = "padding : 7px; ">
                    <div class="alert alert-warning">
                        <form action="tipos_atualiza.php?id=<?php echo $_GET['id']; ?>" method="POST" name="form_atualiza_tipo" id="form_atualiza_tipoo">
                            <label for="atualizar_rotulo">Rótulo</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="rotulo" value="<?php echo $tipos['rotulo']; ?>" id="rotulo" maxlength="30" placeholder="Digite o rótulo" class="form-control" required autocomplete="off">
                            </div>
                            <br>

                            <label for="sigla">Sigla</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                </span>
                                <select name="sigla" id="sigla" class="form-control" required>
                            
                                    <option value="chu" <?php echo $tipos['sigla'] == 'chu' ? 'selected' : '' ?>>chu</option>
                                    <option value="sob" <?php echo $tipos['sigla'] == 'sob' ? 'selected' : '' ?>>sob</option>
                                    <option value="beb" <?php echo $tipos['sigla'] == 'beb' ? 'selected' : '' ?>>beb</option>
                               
                                </select>
                            </div>
                            <br>


                            <input type="submit" value="Atualizar" role="button" name="enviar" id="enviar" class="btn btn-block btn-warning">
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