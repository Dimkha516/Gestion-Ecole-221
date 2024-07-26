<?php
namespace Core;

class App{
    private static $instance;

    private $database;

    private function __construct(){
        $this->database = new Database();
    }

    public static function getInstance() {
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function  getDatabase() {
        return $this->database; 
    } 
}