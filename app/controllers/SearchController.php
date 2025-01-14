<?php

namespace App\Controllers;

class SearchController
{

    public function search()
    {
        try {

            // Passando os dados para a view
            require_once __DIR__ . '/../views/search/search.php';
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function searchResult()
    {
        try {

            // Passando os resultados para a view
            require_once __DIR__ . '/../views/search/search.php';
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
