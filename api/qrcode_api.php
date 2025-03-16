<?php
// qrcode_api.php

// Define o header para informar que o conteúdo retornado é uma imagem PNG
header('Content-Type: ../images/png');

// Inclui a biblioteca do phpqrcode (ajuste o caminho conforme a estrutura do seu projeto)
require_once '../lib/phpqrcode-master/qrlib.php';

// Recebe os dados a serem codificados via parâmetro GET (ex: ?data=seusDados)
// Caso não seja informado, usa um valor padrão
$data = isset($_GET['data']) ? $_GET['data'] : 'Dados QR Code';

// Define os parâmetros para a geração do QR Code:
// - Nível de correção de erro ('L', 'M', 'Q' ou 'H')
// - Tamanho de cada "pixel" do QR Code
// - Tamanho da margem em volta do QR Code
$ecc = 'L';
$pixelSize = 10;
$frameSize = 3;

// Gera o QR Code e envia a imagem diretamente para o navegador.
// O segundo parâmetro é definido como false para que a imagem não seja salva em arquivo.
QRcode::png($data, false, $ecc, $pixelSize, $frameSize);
?>
