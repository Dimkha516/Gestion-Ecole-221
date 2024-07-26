<?php
namespace Core;

use PDO;
use PDOException;

class Database{
    private $pdo;

    public function __construct(){
        $config = require_once "../config/config.php";

        try{
            $this->pdo = new PDO($config['dsn'], $config['username'], $config['password']);
        }
        catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function prepare($query){
        return $this->pdo->prepare($query);
    }

    public function query($query){
        return $this->pdo->query($query);
    }
}