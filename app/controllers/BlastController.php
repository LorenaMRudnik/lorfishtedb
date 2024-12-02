<?php

namespace App\Controllers;

class BlastController
{
    public function blast()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Coleta os dados do formulário
                $fasta = $_POST['fasta'] ?? ''; // Sequência FASTA fornecida pelo usuário
                $program = $_POST['program'] ?? 'blastn'; // Programa, ex: blastn, blastp
                $filter = isset($_POST['filter']) ? 1 : 0; // Filtro ativado ou não
                $expect = $_POST['expect'] ?? ''; // Expect, valor esperado para o alinhamento
                $alignments = $_POST['alignments'] ?? ''; // Número de alinhamentos

                // Endpoint do NCBI BLAST
                $blastEndpoint = "https://blast.ncbi.nlm.nih.gov/blast/Blast.cgi";

                // Prepara os dados para a requisição POST
                $data = [
                    'QUERY' => urlencode($fasta),
                    'PROGRAM' => $program,
                    'FILTER' => $filter,
                    'EXPECT' => $expect,
                    'ALIGNMENTS' => $alignments,
                    'CMD' => 'Put', // Comando inicial
                ];

                // Envia a requisição para iniciar o BLAST
                $response = $this->sendRequest($blastEndpoint, $data);

                // Extrai o RID e o tempo de espera (RTOE)
                $rid = $this->extractValue($response, 'RID');
                $rtoe = $this->extractValue($response, 'RTOE');

                // Exibe o valor de RTOE para depuração
                echo "Tempo de espera estimado: $rtoe segundos\n";

                // Aguarda o tempo necessário
                sleep((int) $rtoe);

                // Recupera os resultados
                $results = $this->fetchResults($blastEndpoint, $rid);

                // Exibe os resultados na tela
                echo "<h2>Resultados do BLAST</h2><pre>$results</pre>";
            } else {
                // Exibe a página inicial do BLAST
                require_once __DIR__ . '/../views/blast/blast.php';
            }
        } catch (\Throwable $th) {
            echo "Erro: " . $th->getMessage();
        }
    }

    /**
     * Envia uma requisição POST para o endpoint BLAST
     */
    private function sendRequest(string $url, array $data): string
    {
        // Configuração do cURL
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/x-www-form-urlencoded",
        ]);

        // Desativar verificação de SSL (para desenvolvimento)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        // Executa a requisição
        $response = curl_exec($ch);

        if ($response === false) {
            throw new \Exception('Erro ao realizar a requisição ao BLAST: ' . curl_error($ch));
        }

        // Fecha a conexão cURL
        curl_close($ch);

        return $response;
    }

    /**
     * Extrai valores (RID ou RTOE) do retorno do servidor BLAST
     */
    private function extractValue(string $response, string $key): string
    {
        preg_match("/^.*$key = .*\$/m", $response, $matches);
        if (!empty($matches)) {
            return trim(str_replace("$key =", '', $matches[0]));
        }
        throw new \Exception("Não foi possível encontrar $key na resposta.");
    }

    /**
     * Recupera os resultados do BLAST
     */
    private function fetchResults(string $url, string $rid): string
    {
        while (true) {
            sleep(20); // Aumenta o intervalo de espera para 20 segundos antes de verificar o status

            // Recupera o status da pesquisa
            $status = file_get_contents("$url?CMD=Get&FORMAT_OBJECT=SearchInfo&RID=$rid");

            // Log do status da pesquisa
            echo "Status da pesquisa: $status\n";

            if (preg_match('/Status=WAITING/', $status)) {
                continue; // Continua aguardando
            }

            if (preg_match('/Status=FAILED/', $status)) {
                throw new \Exception("A pesquisa $rid falhou.");
            }

            if (preg_match('/Status=UNKNOWN/', $status)) {
                throw new \Exception("A pesquisa $rid expirou.");
            }

            if (preg_match('/Status=READY/', $status)) {
                if (preg_match('/ThereAreHits=yes/', $status)) {
                    // Recupera os resultados no formato desejado
                    return file_get_contents("$url?CMD=Get&FORMAT_TYPE=Text&RID=$rid");
                } else {
                    throw new \Exception("Nenhum resultado foi encontrado para a pesquisa $rid.");
                }
            }
        }
    }
}
