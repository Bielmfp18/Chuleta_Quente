<?php

declare(strict_types=1);

namespace Endroid\QrCode;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Color\ColorInterface;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Encoding\EncodingInterface;
use Endroid\QrCode\Writer\PngWriter;

final class QrCode implements QrCodeInterface
{
    public function __construct(
        private string $data,
        private EncodingInterface $encoding = new Encoding('UTF-8'),
        private ErrorCorrectionLevel $errorCorrectionLevel = ErrorCorrectionLevel::Low,
        private int $size = 300,
        private int $margin = 10,
        private RoundBlockSizeMode $roundBlockSizeMode = RoundBlockSizeMode::Margin,
        private ColorInterface $foregroundColor = new Color(0, 0, 0),
        private ColorInterface $backgroundColor = new Color(255, 255, 255)
    ) {
    }

    // ============================
    //       GETTERS
    // ============================
    public function getData(): string
    {
        return $this->data;
    }

    public function getEncoding(): EncodingInterface
    {
        return $this->encoding;
    }

    public function getErrorCorrectionLevel(): ErrorCorrectionLevel
    {
        return $this->errorCorrectionLevel;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getMargin(): int
    {
        return $this->margin;
    }

    public function getRoundBlockSizeMode(): RoundBlockSizeMode
    {
        return $this->roundBlockSizeMode;
    }

    public function getForegroundColor(): ColorInterface
    {
        return $this->foregroundColor;
    }

    public function getBackgroundColor(): ColorInterface
    {
        return $this->backgroundColor;
    }

    // ============================
    //       SETTERS
    // ============================
    public function setData(string $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function setEncoding(string $encoding): self
    {
        // Cria um novo objeto Encoding a partir da string
        $this->encoding = new Encoding($encoding);
        return $this;
    }

    public function setErrorCorrectionLevel(ErrorCorrectionLevel $level): self
    {
        $this->errorCorrectionLevel = $level;
        return $this;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;
        return $this;
    }

    public function setMargin(int $margin): self
    {
        $this->margin = $margin;
        return $this;
    }

    public function setRoundBlockSizeMode(RoundBlockSizeMode $mode): self
    {
        $this->roundBlockSizeMode = $mode;
        return $this;
    }

    public function setForegroundColor(ColorInterface $color): self
    {
        $this->foregroundColor = $color;
        return $this;
    }

    public function setBackgroundColor(ColorInterface $color): self
    {
        $this->backgroundColor = $color;
        return $this;
    }

    // ============================
    //   GERA E SALVA O QR CODE
    // ============================
    public function writeFile(string $path): void
    {
        // Neste exemplo, estamos usando o PngWriter
        // Certifique-se de ter a classe PngWriter instalada/importada
        $writer = new PngWriter();
        
        // O método write() recebe o QrCode e retorna um objeto que pode ser salvo em arquivo
        $writer->write($this)->saveToFile($path);
    }
}
