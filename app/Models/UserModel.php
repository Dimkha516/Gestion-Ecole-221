<?php

namespace App\Models;

use Core\Model;

class UserModel extends Model{ 
    protected $table = 'users3';

    public function findByUsername($username){
        $sql = "SELECT * FROM {$this->table} WHERE username = ?";
        return $this->query($sql, [$username]);
        // $stmt = $this->query($sql, [$username]);
        // return $stmt->fetch(); 
        // var_dump($this->query($sql, [$username]));
        // mister
        // 123
        // professeur 
    }
} 