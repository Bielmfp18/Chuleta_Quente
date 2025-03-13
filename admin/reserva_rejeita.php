<?php
include "../conn/connect.php";
include '../admin/acesso_com.php';

// Obtém o ID da reserva via GET.
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Verifica se o ID é válido.
if ($id == 0) {
    echo "<script>
            alert('ID inválido.');
            window.location.href='reserva_lista.php';
          </script>";
    exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Se o formulário foi submetido (método POST), processa a rejeição.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera o motivo da rejeição enviado via POST.
    $motivo = isset($_POST['motivo']) ? trim($_POST['motivo']) : '';
    
    if (empty($motivo)) {
        echo "<script>
                alert('Motivo da rejeição não informado.');
                window.location.href='reserva_lista.php';
              </script>";
        exit;
    }
    
    // Atualiza a reserva para inativar (ativo = 0) e registra o motivo da negativa.
    $result = $conn->query("UPDATE reserva SET ativo = 0, motivo = '$motivo' WHERE id = $id");
    
    if ($result) {
        // Recupera o e-mail do cliente.
        $res = $conn->query("SELECT cliente_email FROM reserva WHERE id = $id");
        $row = $res->fetch_assoc();
        $clienteEmail = $row['cliente_email'];
    
        // Inclui as classes do PHPMailer.
        require '../lib/PHPMailer-master/src/PHPMailer.php';
        require '../lib/PHPMailer-master/src/SMTP.php';
        require '../lib/PHPMailer-master/src/Exception.php';
    
        $mail = new PHPMailer(true);
    
        try {
            // Configurações do servidor SMTP.
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'chuletaquentechurrasco@gmail.com';
            $mail->Password   = 'opbf zlbp kwfi sidp';  // Use a senha de aplicativo se necessário.
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;
    
            // Em ambiente local, para contornar erros de verificação de certificado.
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true
                )
            );
    
            // Configura os remetente e destinatário.
            $mail->setFrom('chuletaquentechurrasco@gmail.com', 'Chuleta Quente Churrasco');
            $mail->addAddress($clienteEmail);
    
            // Define o charset para UTF-8 para suportar acentos.
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);
            $mail->Subject = 'Reserva Negada - Chuleta Quente Churrasco';
            $mail->Body    = "Olá amigo,<br><br>Sua reserva foi infelizmente negada, mas não se desanime, você poderá voltar num momento oportuno.<br><br><strong>Motivo:</strong> $motivo<br><br>Atenciosamente,<br>Chuleta Quente Churrasco";
            $mail->AltBody = "Olá,\n\nSua reserva foi negada.\n\nMotivo: $motivo\n\nAtenciosamente,\nChuleta Quente Churrasco";
    
            // Tenta enviar o e-mail.
            $mail->send();
    
            echo "<script>
                    alert('Reserva rejeitada com sucesso! E-mail enviado ao cliente.');
                    window.location.href='reserva_lista.php';
                  </script>";
            exit;
        } catch (Exception $e) {
            echo "<script>
                    alert('Reserva rejeitada, mas ocorreu um erro ao enviar o e-mail: {$mail->ErrorInfo}');
                    window.location.href='reserva_lista.php';
                  </script>";
            exit;
        }
    } else {
        echo "<script>
                alert('Erro ao desativar a reserva.');
                window.location.href='reserva_lista.php';
              </script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Rejeitar Reserva - Chuleta Quente Churrasco</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilo.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .container4 {
            height: 100%;
            padding-top: 130px;
        }
    </style>
</head>
<body>
    <?php include '../admin/menu_adm.php'; ?>
    <main class="container4">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4">
                <div class="panel panel-danger">
                    <div class="panel-heading" style="position: relative; text-align: center;">
                        <!-- Botão de voltar posicionado à esquerda -->
                        <a href="reserva_lista.php" style="position: absolute; left: 15px; top: 15px; text-decoration: none;">
                            <button class="btn btn-danger" type="button">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            </button>
                        </a>
                        <h2 class="breadcrumb alert-danger" style="display: inline-block; margin: 0;">
                            Rejeitar Reserva
                        </h2>
                    </div>
                    <div class="panel-footer text-center">
                        <form action="reserva_rejeita.php?id=<?php echo $id; ?>" method="POST" name="form_atualiza_reserva">
                            <div class="form-group">
                                <label for="motivo" style="font-size:20px; padding:10px;">Motivo:</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                                    </span>
                                    <textarea name="motivo" id="motivo" placeholder='Digite o motivo (Ex: "Sem mesas disponíveis", "Sem horário para fazer a Reserva", etc.)' class="form-control" required autocomplete="off"></textarea>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top:30px;">
                                <input type="submit" value="Confirmar" name="enviar" id="enviar" class="btn btn-danger btn-block" style="height: 33px;">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
