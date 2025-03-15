<?php
// Inclui as bibliotecas e arquivos necessários (Todas essas bibliotecas foram instaldas por fora)
require '../lib/phpqrcode-master/qrlib.php';
include '../admin/acesso_com.php';
include '../conn/connect.php';

// Inclui as classes do PHPMailer  (Todas essas bibliotecas foram instaldas por fora)
require '../lib/PHPMailer-master/src/PHPMailer.php';
require '../lib/PHPMailer-master/src/SMTP.php';
require '../lib/PHPMailer-master/src/Exception.php';

// Declarações use usadas para ficar no escopo global, logo após os includes.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Valida o ID enviado por GET e recupera os dados da reserva (incluindo o e-mail do cliente)
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql_row = $conn->query("SELECT * FROM reserva WHERE id = $id");
    if ($sql_row && $sql_row->num_rows > 0) {
        $row = $sql_row->fetch_assoc();
        $clienteEmail = $row['cliente_email'];
    } else {
        die("Reserva não encontrada.");
    }
} else {
    die("ID inválido.");
}

// Processa o formulário somente se for POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera o número da mesa informado pelo usuário.
    $num_mesa = intval($_POST['num_mesa']);

    // Atualiza a reserva no banco (define o número da mesa e ativa a reserva).
    $sql = $conn->query("UPDATE reserva SET num_mesa = $num_mesa, ativo = 1 WHERE id = $id");

    if ($sql) {
        // Define os dados para o QR Code e e-mail.
           // Gera um número de reserva aleatório.
           $codigoReserva = rand(100000000, 999999999);  // Código dinâmico.
        $nomeArquivo = "reserva__chuleta_quente_churrasco.png";   // Nome do arquivo (QRcode) a ser gerado.

        // Gera o QR Code e salva a imagem e guarda a imagem na pasta de QRcode.
        $nomeArquivo = __DIR__ . '/../phpQrcode/reserva.png';
        QRcode::png($codigoReserva, $nomeArquivo);
        

        // Cria uma instância do PHPMailer.
        $mail = new PHPMailer(true);

        // Define o charset para UTF-8 para suportar acentos e "ç".
        $mail->CharSet = 'UTF-8';


        try {
            // Configurações do servidor SMTP (Os dados necessários para o funcionamento do envio do email com o QRcode)
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'chuletaquentechurrasco@gmail.com';
            $mail->Password   = 'opbf zlbp kwfi sidp';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Em ambiente local, para contornar erros de verificação de certificado.
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer'       => false, //Não verifica a cadeia de certificados.
                    'verify_peer_name'  => false, //Não confirma o nome do certificado.
                    'allow_self_signed' => true // Permite certificados autoassinados.
                )
            );

            // Configura os destinatários e de quem vai ser enviado o e-mail.
            $mail->setFrom('chuletaquentechurrasco@gmail.com', 'Chuleta Quente Churrasco');
            $mail->addAddress($clienteEmail);

            // Anexa o arquivo do QR Code.
            $mail->addAttachment($nomeArquivo);

            // Configura o conteúdo do e-mail a ser enviado (não há formatação para acentos e "ç").
            $mail->isHTML(true);
            $mail->Subject = 'Seu QRcode de Reserva';
            $mail->Body = 'Olá, <br>Segue em anexo o QR Code com seu número de reserva. Guarde-o para apresentá-lo no dia do seu comparecimento ao estabelecimento da Churrascaria Chuleta Quente Churrasco: ' . $codigoReserva;
            $mail->AltBody = 'Olá, segue em anexo o QR Code: ' . $codigoReserva;

            // Tenta enviar o e-mail.
            $mail->send();

            //Traz a mensagem de sucesso ou falha.
            echo "<script>
                    alert('Reserva confirmada e e-mail enviado com sucesso!');
                    window.location.href='reserva_lista.php';
                  </script>";
            exit;
        } catch (Exception $e) {
            echo "<script>
                    alert('Reserva confirmada, mas ocorreu um erro ao enviar o e-mail: {$mail->ErrorInfo}');
                    window.location.href='reserva_lista.php';
                  </script>";
            exit;
        }
    } else {
        echo "<script>
                alert('Erro ao confirmar a reserva.');
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
    <title>Área de Cliente - Chuleta Quente</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap e CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilo.css" type="text/css">
    <!-- Font Awesome -->
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
                <div class="panel panel-info">
                    <div class="panel-heading" style="text-align: center;">
                        <h2 class="breadcrumb alert-secondary">
                            <a href="reserva_lista.php" style="text-decoration: none;">
                                <button class="btn btn-primary" type="button" style="margin-right: 10px;">
                                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                </button>
                            </a>
                            Regras para confirmar o Pedido de Reserva
                        </h2>
                    </div>
                    <div class="panel-body" style="text-align:center; font-size:20px;">
                        <p>Adicione um número de mesa para confirmar esta reserva.</p>
                    </div>
                    <div class="panel-footer text-center">
                        <form action="reserva_aceita.php?id=<?php echo $row['id']; ?>" method="POST" name="form_atualiza_reserva">
                            <div class="form-group">
                                <label for="num_mesa" style="font-size:20px;">Número da Mesa:</label>
                                <div class="input-group" style="width:150px; margin:10px auto;">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                                    </span>
                                    <input type="number" name="num_mesa" id="num_mesa" value="1" min="1" max="99" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top:30px;">
                                <input type="submit" value="Confirmar Reserva" name="enviar" id="enviar" class="btn btn-primary btn-block" style="height: 33px;">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Bootstrap js -->
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>