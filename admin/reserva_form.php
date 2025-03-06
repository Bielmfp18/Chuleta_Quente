<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Regras para Pedido de Reserva</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap e CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <main class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
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
                        <!-- Botão para direcionar para o formulário de pedido -->
                        <a href="../cliente/pedido_reserva.php" class="btn btn-primary btn-lg">
                            Aceito as Regras e Fazer o Pedido
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Scripts do Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
