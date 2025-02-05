<?php
namespace Core;

class Session{
    public static function start() {
        session_start();
    }

    public static function set($key, $value){
        $_SESSION[$key] = $value;
    }

    public static function get($key){
        return $_SESSION[$key] ?? null;
    }

    public static function isset($key){
        return isset($_SESSION[$key]);
    }

    public static function close() {
        session_destroy();
    }
}
