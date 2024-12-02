<?php

namespace App\Controllers;

use App\Infra\Database;

class SearchController
{
    public function search()
    {
        try {
            // Consultando dados do banco
            $searchAll = Database::getInstance()->getSearchAll();
            $superfamily = Database::getInstance()->getSuperfamily();
            $order = Database::getInstance()->getOrder();
            $class = Database::getInstance()->getClass();

            // Passando os dados para a view
            require_once __DIR__ . '/../views/search/search.php';
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function searchResult()
    {
        try {
            $results = [];

            if (isset($_POST['search-radio'])) {
                $filter = $_POST['search-radio'];
                $name_fish = $_POST['scientific_name_fish'];

                if ($filter === 'class') {
                    $className = $_POST['class_name'];
                    $results = Database::getInstance()->createTable($name_fish, 'class', $className);
                } elseif ($filter === 'order') {
                    $orderName = $_POST['order_name'];
                    $results = Database::getInstance()->createTable($name_fish, 'order', $orderName);
                } elseif ($filter === 'superfamily') {
                    $superfamilyName = $_POST['superfamily_name'];
                    $results = Database::getInstance()->createTable($name_fish, 'superfamily', $superfamilyName);
                } else {
                    echo "Nenhum filtro foi selecionado.";
                }
            }

            // Passando os resultados para a view
            require_once __DIR__ . '/../views/search/search.php';
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
