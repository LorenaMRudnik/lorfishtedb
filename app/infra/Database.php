<?php

namespace App\Infra;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        try {
            $this->connection = new PDO("pgsql:host=localhost;port=5430;dbname=LORFISHDB", "postgres", "123569");
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro ao conectar com o banco de dados: " . $e->getMessage());
        }
    }

    //instancia da classe Database
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Método para obter a conexão com o banco de dados
    public function getConnection()
    {
        return $this->connection;
    }

    // Método para listar todos os peixes
    public function getSearchAll()
    {
        $db = $this->getConnection();
        $stmt = $db->query('SELECT scientific_name_fish FROM specie_fish');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Metodos para retornar as SF cadastradas
    public function getSuperfamily()
    {
        $db = $this->getConnection();
        $stmt = $db->query('SELECT superfamily_name FROM superfamily_wicker');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Metodo para retornar as Ordens cadastradas
    public function getOrder()
    {
        $db = $this->getConnection();
        $stmt = $db->query('SELECT order_name FROM order_wicker');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Metodo para retornar as Classes cadastradas
    public function getClass()
    {
        $db = $this->getConnection();
        $stmt = $db->query('SELECT class_name FROM class_wicker');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Metodo para criar a Table em Search
    public function createTable($name_fish, $filter, $value)
    {
        $db = $this->getConnection();

        if ($filter == 'class') {
            $stmt = $db->prepare("SELECT * FROM analysis_info WHERE class_name = :value AND scientific_name_fish = :name_fish");
        } elseif ($filter == 'order') {
            $stmt = $db->prepare("SELECT * FROM analysis_info WHERE order_name = :value AND scientific_name_fish = :name_fish");
        } elseif ($filter == 'superfamily') {
            $stmt = $db->prepare("SELECT * FROM analysis_info WHERE superfamily_name = :value AND scientific_name_fish = :name_fish");
        }

        $stmt->bindParam(':name_fish', $name_fish);
        $stmt->bindParam(':value', $value);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Metodo para criar a Table em Statistics
    public function createTableStatistics($name_fish)
    {
        $db = $this->getConnection();
        $stmt = $db->prepare("SELECT superfamily_name, COUNT(*) AS count FROM analysis_info WHERE scientific_name_fish = :name_fish GROUP BY superfamily_name");
        $stmt->bindParam(':name_fish', $name_fish);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
