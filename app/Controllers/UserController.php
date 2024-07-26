<?php
namespace App\Controllers;

use Core\Controller;
use Core\SecurityDatabase;
use Core\Session;

class UserController extends Controller
{
    private $securityDatabase;
 
    public function __construct()
    {
        parent::__construct();
        $this->securityDatabase = new SecurityDatabase();
    }

    public function showLogin()
    {
        $this->renderView('login');
        // $this->renderView('boutiquier_dashboard');
    }

    public function login()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user = $this->securityDatabase->login($username, $password);
        $loginError = 'Utilisateur inconnu';
 
        if ($user) {
            Session::set('user', $user);
            $role = $user['role'];
            if ($role === 'professeur') { 
                $this->redirect('/planning');
            } else {
                $this->redirect('/otherUsers');
            }
        } else {
            $this->renderView('login', [
                'error' => 'Utilisateur inconnu',
                'loginError' => $loginError
            ]);
            // $this->redirect('/planning');
        }
    }

    public function showTeacherDashboard()
    {
        $this->renderView('cours');
    } 

    public function showPlanningDashboard()
    {
        $this->renderView('planning');
    }

    public function showStudentDashboard() {
        $this->renderView('etudiant');
    }

    public function showStudentAbsences() {
        $this->renderView('absences');
    }
}