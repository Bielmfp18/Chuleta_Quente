<?php
// Inclui o autoload do Composer (lembrar de ter executado "composer install")
require_once __DIR__ . '/../vendor/autoload.php';
// [Explicação: Este comando carrega automaticamente todas as dependências definidas via Composer, localizadas na pasta "vendor".]

// Inclui as bibliotecas e arquivos necessários para o código.
require_once __DIR__ . '/../lib/phpqrcode-master/qrlib.php';
// [Explicação: Carrega a biblioteca PHP QR Code, que será utilizada para gerar os QR Codes.]
include __DIR__ . '/../admin/acesso_com.php';
// [Explicação: Inclui o arquivo de controle de acesso, garantindo que apenas usuários autorizados possam acessar a página.]
include __DIR__ . '/../conn/connect.php';
// [Explicação: Inclui o arquivo de conexão com o banco de dados.]

/* Inclui as classes do PHPMailer (caso não estejam sendo carregadas pelo Composer) */
require_once __DIR__ . '/../lib/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../lib/PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/../lib/PHPMailer-master/src/Exception.php';
// [Explicação: Esses comandos garantem que as classes necessárias do PHPMailer sejam carregadas, possibilitando o envio de e-mails.]

/* Declarações de uso para ficar no escopo global. */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// [Explicação: Define os namespaces das classes que serão utilizadas para facilitar o uso sem precisar escrever o caminho completo a cada vez.]

// Função para obter a imagem do QR Code via URL, usando file_get_contents ou cURL.
function getQRCodeImageData($url) {
    // Tenta file_get_contents se allow_url_fopen estiver habilitado.
    if (ini_get('allow_url_fopen')) {
        $data = file_get_contents($url);
        if ($data !== false) {
            return $data;
        }
    }
    // Se file_get_contents falhar, utiliza cURL (se disponível)
    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    return false;
    // [Explicação: A função tenta primeiro usar file_get_contents para obter os dados da URL; se isso falhar, tenta com cURL. Retorna os dados da imagem ou false se não conseguir.]
}

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
// [Explicação: Aqui o script valida se o parâmetro 'id' foi passado na URL, busca a reserva no banco de dados e armazena o e-mail do cliente para envio posterior.]

// Processa o formulário somente se for POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera o número da mesa informado pelo usuário.
    $num_mesa = intval($_POST['num_mesa']);
    // [Explicação: Converte o número informado pelo usuário para um inteiro.]

    // Atualiza a reserva no banco (define o número da mesa e ativa a reserva).
    $sql = $conn->query("UPDATE reserva SET num_mesa = $num_mesa, ativo = 1 WHERE id = $id");
    // [Explicação: Atualiza a reserva definindo o número da mesa e marcando a reserva como ativa no banco de dados.]

    if ($sql) {
        // Define os dados para o QR Code e e-mail.
        // Gera um número de reserva aleatório (código dinâmico).
        $codigoReserva = rand(100000000, 999999999);
        // [Explicação: Gera um código único aleatório para a reserva que será codificado no QR Code.]

        // Gera a URL para a API do QR Code de forma dinâmica:
        $apiPath = __DIR__ . '/../api/qrcode_api.php';
        // [Explicação: Define o caminho físico do arquivo da API que gera o QR Code.]

        // Normaliza os caminhos para usar forward slashes
        $documentRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
        $realApiPath = str_replace('\\', '/', realpath($apiPath));
        // [Explicação: Converte possíveis barras invertidas em barras normais para compatibilidade em URLs.]

        // Obtém o caminho relativo removendo a parte do DOCUMENT_ROOT
        $relativePath = str_replace($documentRoot, '', $realApiPath);
        // [Explicação: Remove a parte do caminho que corresponde ao DOCUMENT_ROOT para obter o caminho relativo do arquivo.]

        $apiUrl = 'http://' . $_SERVER['HTTP_HOST'] . $relativePath . '?data=' . urlencode($codigoReserva);
        // [Explicação: Monta a URL completa da API, utilizando o host atual, o caminho relativo e passando o código da reserva como parâmetro.]

        $qrImageData = getQRCodeImageData($apiUrl);
        if ($qrImageData === false) {
            die("Erro ao gerar o QR Code via API.");
        }
        // [Explicação: Chama a função para obter os dados da imagem do QR Code a partir da API. Se falhar, interrompe o script com uma mensagem de erro.]

        // Cria uma instância do PHPMailer.
        $mail = new PHPMailer(true);
        // [Explicação: Instancia o objeto PHPMailer para que possamos configurar e enviar o e-mail.]

        // Define o charset para UTF-8 para suportar acentos e "ç".
        $mail->CharSet = 'UTF-8';

        try {
            // Configurações do servidor SMTP.
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'chuletaquentechurrasco@gmail.com';
            $mail->Password   = 'opbf zlbp kwfi sidp';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;
            // [Explicação: Configura o PHPMailer para usar o servidor SMTP do Gmail com as credenciais fornecidas.]

            // Em ambiente local, contorna erros de verificação de certificado.
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true
                )
            );
            // [Explicação: Configura opções de SSL para evitar erros de verificação de certificado, útil em ambientes de desenvolvimento local.]

            // Configura os destinatários e o remetente.
            $mail->setFrom('chuletaquentechurrasco@gmail.com', 'Chuleta Quente Churrasco');
            $mail->addAddress($clienteEmail);
            // [Explicação: Define o remetente e o destinatário do e-mail.]

            // Anexa a imagem do QR Code obtida via API.
            $mail->addStringAttachment($qrImageData, 'reserva.png', 'base64', 'image/png');
            // [Explicação: Anexa o QR Code (que foi gerado pela API) como um arquivo chamado "reserva.png" no e-mail.]

            // Configura o conteúdo do e-mail.
            $mail->isHTML(true);
            $mail->Subject = 'Seu QRcode de Reserva';
            $mail->Body = 'Olá, <br>Segue em anexo o QR Code com seu número de reserva. Guarde-o para apresentá-lo no dia do seu comparecimento à Churrascaria Chuleta Quente Churrasco: ' . $codigoReserva;
            $mail->AltBody = 'Olá, segue em anexo o QR Code: ' . $codigoReserva;
            // [Explicação: Define o assunto, o corpo (em HTML) e o corpo alternativo (texto plano) do e-mail.]

            // Tenta enviar o e-mail.
            $mail->send();
            // [Explicação: Tenta enviar o e-mail utilizando as configurações feitas.]

            // Exibe mensagem de sucesso.
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
                                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
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
