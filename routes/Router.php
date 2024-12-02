<?php

namespace Routes;

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;
use App\Controllers\SearchController;
use App\Controllers\StatisticsController;
use App\Controllers\BlastController;
use App\Controllers\TeamController;
use App\Controllers\DownloadController;


class Router
{
    private $routes = [];

    // Adicionar rotas
    public function addRoute($method, $path, $callback)
    {
        $this->routes[] = compact('method', 'path', 'callback');
    }

    // Processar a rota atual
    public function handleRequest()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $route['path'] === $requestUri) {
                return call_user_func($route['callback']);
            }
        }

        http_response_code(404);
        echo "404 - Not Found";
    }

    public static function execute()
    {
        // Instancia os controladores
        $homeController = new HomeController();
        $searchController = new SearchController();
        $statisticsController = new StatisticsController();
        $blastController = new BlastController();
        $teamController = new TeamController();
        $downloadController = new DownloadController();


        // Instancia o roteador
        $router = new Router();

        // Rota GET para exibir a página inicial
        $router->addRoute('GET', '/', [$homeController, 'index']);
        $router->addRoute('GET', '/home', [$homeController, 'index']);

        // Rota GET para exibir o formulário de pesquisa
        $router->addRoute('GET', '/search', [$searchController, 'search']);

        // Rota POST para processar o formulário de pesquisa e mostrar os resultados
        $router->addRoute('POST', '/search', [$searchController, 'searchResult']);

        // Rota GET para exibir a página de estatísticas
        $router->addRoute('GET', '/statistics', [$statisticsController, 'statistics']);

        // Rota GET para exibir a página do blast
        $router->addRoute('GET', '/blast', [$blastController, 'blast']);

        // Rota POST para processar o formulário de blast
        $router->addRoute('POST', '/blast', [$blastController, 'blast']);

        // Rota GET para exibir a página do Team
        $router->addRoute('GET', '/team', [$teamController, 'team']);

        // Rota GET para exibir a página de downloads
        $router->addRoute('GET', '/downloads', [$downloadController, 'downloads']);

        // Rota GET para download de arquivos FASTA
        $router->addRoute('GET', '/files/fasta/(:any)', [$downloadController, 'downloadFasta']);

        // Rota GET para download de arquivos GFF
        $router->addRoute('GET', '/download/gff/(:any)', [$downloadController, 'downloadGff']);

        $router->handleRequest();
    }
}
