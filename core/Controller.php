<?php
namespace Core;


class Controller{
    protected $session;

    public function __construct(){
        $this->session = new Session();
    }

    protected function renderView($view, $data = []){
        extract($data);
        $viewPath = "../app/Views/{$view}.php";
        if(file_exists($viewPath)){
            require $viewPath;
        } else{
            require "../app/Views/notFound.php";
        }
    }

    protected function redirect($url){
        header("Location: $url");
        exit();
    }


}