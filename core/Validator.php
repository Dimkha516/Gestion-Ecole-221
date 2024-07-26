<?php
namespace Core;

use App\Models\UserModel;

class Validator
{
    private $errors = [];
    private $usersModel;



    private $db;

    public function __construct()
    {
        $this->usersModel = new UserModel();
    }

    // public function __construct(){
    //     $this->db = new SecurityDatabase();
    // }

    // public static function validate($username, $password)
    // {   


    //     if ($username === 'professeur' && $password === 'password') {
    //         return ['role' => 'professeur'];
    //     } else if ($username === 'client' && $password === 'password') {
    //         return ['role' => 'client'];
    //     }
    //     return false;
    // }

    public function validate($username, $password)
    {
        // Rechercher l'utilisateur par nom d'utilisateur
        $user = $this->usersModel->findByUsername($username);
        error_log(print_r($user, true)); // Debug: affiche l'utilisateur trouvé


        if ($user && isset($user['password'])) {    
            // Vérifier le mot de passe (assurez-vous que le mot de passe est correctement haché dans la base de données)
            // Pour l'exemple, supposons que le mot de passe est en clair dans la base de données (mauvaise pratique, utilisez le hachage en production)
            if ($user['password'] === $password) {
                return ['role' => $user['role']]; // Retourner le rôle de l'utilisateur
            }
        }

        return false; // Identifiants invalides
    }

}