<?php
include('phpqrcode/qrlib.php');

$file = 'qr_code_custom.png';
$data = 'https://www.exemplo.com';

// Nível de correção de erro (H = alta)
$level = 'H';
// Tamanho do QR Code
$size = 10;
// Margem
$margin = 2;

QRcode::png($data, $file, $level, $size, $margin);

echo '<img src="' . $file . '" />';
?>


<?php
include('phpqrcode/qrlib.php');

// Dados do QR Code
$data = 'https://www.youtube.com/';

// Exibe diretamente no navegador
header('Content-Type: image/png');

// Gera o QR Code e exibe na tela (sem salvar em arquivo)
QRcode::png($data);
?>

 
