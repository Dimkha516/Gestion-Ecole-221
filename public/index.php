<?php 


// http://www.projet221.com:8089/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//  echo "BISMILAH";  

require_once '../vendor/autoload.php';


use Core\Route;
use Core\Session; 
use App\Controllers\UserController;

Session::start();
//------------------------LOGIN
Route::post('/login', [UserController::class, 'login']);
Route::get('/', [UserController::class, 'showLogin']);

//---------------------------ETUDIANT: 
// Route::get('/etudiant', [UserController::class, 'showStudentDashboard']);
// Route::get ('/absences', [UserController::class, 'showStudentAbsences']);
Route::get('/absences', ['App\Controllers\EtudiantController', 'getStudentAbsences']); 
Route::get('/etudiant', ['App\Controllers\EtudiantController', 'getStudentCours']);
Route::get('/sessionsEtudiant', ['App\Controllers\EtudiantController', 'getStudentSessions']);

//------------------------------PROFESSEEUR: 
Route::get('/cours', ['App\Controllers\ProfController', 'getCours']);
Route::post('/cours', ['App\Controllers\ProfController', 'getCours']);
Route::get('/planning', ['App\Controllers\ProfController', 'showPlanning']);
// Route::get('/cours?page=:page', ['App\Controllers\ProfController', 'getCours']);


Route::run();


// Route::get('/planning', [UserController::class, 'showPlanningDashboard']);
// Route::get('/login', [UserController::class, 'showLogin']);
// Route::get('/cours', [UserController::class, 'showTeacherDashboard']);

// dev.io
// https://openui.fly.dev/ai/new

/*
1️: LES ROUTES
2: LA BASE DE DONNÉES
3: LA CONNEXION
4: LES SESSIONS
5: MODIFIER LA BD DANS CONFIG.PHP
6: AJOUTER LES AUTRES REDIRECTIONS DANS USERCONTROLLER

Professeur: filtre par semestre et module pour le professeur
Etudiant: 
pour demain: Trello Maquettage Diag de classe et diag de usecase

POUR DEMAIN MERCREDI:
 --------------LE FORMAT DU CALANDRIER N'EST PAS BON
 -------------- GÉRER LE MARQUAGE ET LA JUSTIFICATION ABSENCE
*/ 