<?php

include '../admin/acesso_com.php';
include '../conn/connect.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados enviados pelo formulário
    $cliente_nome = $_POST['nome'];
    $cliente_cpf   = $_POST['cpf'];
    $cliente_email = $_POST['email'];
    $data          = $_POST['data'];
    $horario       = $_POST['horario'];
    $num_pessoas   = $_POST['num_pessoas'];
    $motivo        = $_POST['motivo'];
    $status        = $_POST['status']; // Deve ser 1 para reserva ativa

    // Monta a query especificando os campos (boa prática para evitar problemas com a ordem dos campos)
    $sql = "INSERT INTO reserva (id, cliente_nome, cliente_cpf, cliente_email, data, horario, num_pessoas, motivo, ativo) 
            VALUES (0, '$cliente_nome', '$cliente_cpf', '$cliente_email', '$data', '$horario', $num_pessoas, '$motivo', $status)";

    try {
        // Executa a query e, se houver erro, lança uma exceção com a mensagem do MySQL
        if (!$conn->query($sql)) {
            throw new mysqli_sql_exception($conn->error, $conn->errno);
        }

        echo "<script>
                alert('Nova reserva inserida com sucesso!');
                window.location.href='reserva_lista.php';
              </script>";
    } catch (mysqli_sql_exception $e) {
        // Se o erro for de duplicidade (código 1062), exibe a mensagem correspondente
        if ($e->getCode() == 1062) {
            echo "<script>
                    alert('Esta reserva já está cadastrada!');
                    window.location.href='index.php';
                  </script>";
        } else {
            // Exibe o erro real para ajudar na depuração
            echo "<script>
                    alert('Erro ao tentar inserir a nova reserva. Erro: " . $e->getMessage() . "');
                    window.location.href='index.php';
                  </script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Área de Cliente - Chuleta Quente</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap e CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilo.css" type="text/css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<style>
    .container4 {
        justify-content: center;
        height: 100%;
    }
</style>

<body>
    <?php include '../cliente/menu_adm_cliente.php'; ?>
    <main class="container4">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4">
                <h2 class="breadcrumb alert-primary">
                    <a href="reserva_lista_cliente.php" style="text-decoration: none;">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-chevron-left" aria-hidden="true"></i>
                        </button>
                    </a>
                    Pedido de Reserva
                </h2>
    </main>
    <main class="container4">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h2 class="panel-title text-center">Regras para Pedido de Reserva</h2>
                    </div>
                    <div class="panel-body">
                        <p><strong>1.</strong> A reserva deve ser feita com no mínimo <strong>12 horas</strong> de antecedência.</p>
                        <p><strong>2.</strong> A reserva deve ser feita com no máximo <strong>60 dias</strong> de antecedência.</p>
                        <p><strong>3.</strong> Apenas um pedido de reserva por dia para o mesmo <strong>CPF</strong>.</p>
                        <p><strong>4.</strong> É necessário preencher todos os campos de cadastro e reserva.</p>
                    </div>
                    <div class="panel-footer text-center">
                        <!-- Botão para direcionar para o formulário de pedido
                        <a href="../cliente/pedido_reserva.php" class="btn btn-primary btn-lg">
                            Aceito as Regras e Fazer o Pedido
                        </a> -->

    </main>

    <main class="container4">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4">
                <!-- Action vazia para postar para o próprio arquivo -->
                <form action="pedido_reserva.php" name="form_insere_reserva" id="form_insere_reserva" method="POST" enctype="multipart/form-data">
                    <div class="thumbnail">
                        <div class="alert alert-primary">
                            <!-- Campo Nome -->
                            <label for="nome">Nome Completo:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fas fa-user text-primary" aria-hidden="true"></i>
                                </span>
                                <input type="text" name="nome" id="nome" autofocus maxlength="100" placeholder="Digite o nome completo" class="form-control" required autocomplete="on">
                            </div>
                            <br>

                            <!-- Campo CPF -->
                            <label for="cpf">CPF:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fas fa-id-card text-info" aria-hidden="true"></i>
                                </span>
                                <input type="text" name="cpf" id="cpf" maxlength="14" pattern="[0-9]{3}\.[0-9]{3}\.[0-9]{3}-[0-9]{2}" placeholder="000.000.000-00" class="form-control" required>
                            </div>
                            <br>

                            <!-- Campo Email -->
                            <label for="email">Email:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fas fa-envelope" aria-hidden="true"></i>
                                </span>
                                <input type="text" name="email" id="email" maxlength="300" placeholder="Digite seu email." class="form-control" required autocomplete="off">
                            </div>
                            <br>

                            <!-- Campo Data -->
                            <label for="data">Data:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                                </span>
                                <input type="date" name="data" id="data" value="2025-03-05" class="form-control" required autocomplete="off">
                            </div>
                            <br>

                            <!-- Campo Horário -->
                            <label for="horario">Horário:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fas fa-clock" aria-hidden="true"></i>
                                </span>
                                <input type="time" name="horario" id="horario" value="12:00" class="form-control" required autocomplete="off">
                            </div>
                            <br>

                            <!-- Número de Pessoas -->
                            <label for="num_pessoas">Número de Pessoas:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fas fa-users" aria-hidden="true"></i>
                                </span>
                                <input type="number" name="num_pessoas" id="num_pessoas" value="1" min="1" max="99" class="form-control" required>
                            </div>
                            <br>

                            <!-- Campo Motivo -->
                            <label for="motivo">Motivo:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fas fa-comment" aria-hidden="true"></i>
                                </span>
                                <textarea name="motivo" id="motivo" placeholder='Digite seu motivo (Ex: "Casamento", "Aniversário", etc.)' class="form-control" required autocomplete="off"></textarea>
                            </div>
                            <br>

                            <!-- Campo Status oculto (1 = ativo) -->
                            <input type="hidden" name="status" id="status" value="1">

                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <!-- Botão de Cancelar -->
                                    <a href="../admin/reserva_desativa.php" class="btn btn-danger btn-block">Cancelar</a>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <!-- Botão de Fazer o Pedido -->
                                    <input type="submit" value="Fazer o Pedido" role="button" name="enviar" id="enviar" class="btn btn-primary btn-block">
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        </div>
        </div>
        </form>
        </div>
        </div>
    </main>

    <!-- Scripts do Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>