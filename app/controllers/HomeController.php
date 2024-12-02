<?php

namespace App\Controllers;

class HomeController
{
    public function index()
    {
        try {
            include __DIR__ . '/../views/home/index.php';
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
