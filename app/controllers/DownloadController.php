<?php

namespace App\Controllers;

class DownloadController
{
    public function downloads()
    {
        include __DIR__ . '/../views/download/download.php';
    }

    public function downloadFasta($scientificName)
    {
        // Corrige os espaços na URL e no nome do arquivo
        $scientificName = str_replace('+', ' ', $scientificName);
        $filePath = __DIR__ . "/../../public/files/fasta/{$scientificName}.fasta"; // Caminho correto para o arquivo

        if (file_exists($filePath)) {
            // Configura os cabeçalhos para forçar o download
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));

            // Lê o arquivo e envia para o navegador
            readfile($filePath);
            exit;
        } else {
            // Se o arquivo não existir, exibe um erro
            http_response_code(404);
            echo "Arquivo não encontrado: " . htmlspecialchars($filePath);
            exit;
        }
    }

    public function downloadGff($scientificName)
    {
        $filePath = __DIR__ . "/../../public/files/gff/{$scientificName}.gff"; // Caminho do arquivo

        if (file_exists($filePath)) {
            // Limpa o output buffer para garantir que nenhum conteúdo anterior seja enviado
            ob_clean();

            // Configura os cabeçalhos para forçar o download
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));


            // Lê o arquivo em blocos para evitar problemas com arquivos grandes
            $chunksize = 1024 * 1024; // 1MB
            $handle = fopen($filePath, 'rb');
            while (!feof($handle)) {
                echo fread($handle, $chunksize);
                ob_flush();
                flush();
            }
            fclose($handle);
            exit;
        } else {
            http_response_code(404);
            echo "Arquivo não encontrado.";
            exit;
        }
    }
}
