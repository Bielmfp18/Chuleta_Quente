<?php

declare(strict_types=1);

namespace Endroid\QrCode\Writer\Result;

use Endroid\QrCode\Matrix\MatrixInterface;

abstract class AbstractResult implements ResultInterface
{
    public function __construct(
        private readonly MatrixInterface $matrix,
    ) {
    }

    public function getMatrix(): MatrixInterface
    {
        return $this->matrix;
    }

    public function getDataUri(): string
    {
        return 'data:' . $this->getMimeType() . ';base64,' . base64_encode($this->getString());
    }

    public function saveToFile(string $path): void
    {
        $string = $this->getString();
        // Obtém o diretório a partir do caminho completo
        $directory = dirname($path);
        // Se o diretório não existir, cria-o recursivamente com as permissões 0755
        if (!is_dir($directory)) {
            // O operador @ suprime o aviso caso o diretório já exista
            @mkdir($directory, 0755, true);
        }
        file_put_contents($path, $string);
    }
}
