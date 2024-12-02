<?php

namespace App\Controllers;

class TeamController
{
    public function team()
    {
        try {
            require_once __DIR__ . '/../views/team/team.php';
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
