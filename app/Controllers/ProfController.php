<?php
namespace App\Controllers;

use Core\Controller;
use Core\Validator;
use Core\SecurityDatabase;

class ProfController extends Controller
{
    private $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = new SecurityDatabase();
    }

    // VERSIO AVEC PAGINATION:
    // public function getCours($page = 1)
    public function getCours()
    {   

        $currentPage = isset($_POST['page']) ? (int)$_POST : 1;
        $idTest = 1;
        $fetchError = "Erreur de récupération des données";
        $itemsPerPage = 3;
        // $offset = (($_POST['page']) - 1) * $itemsPerPage;
        $offset = ($currentPage - 1) * $itemsPerPage;

        // Compter le nombre total de cours pour la pagination
        $totalCoursStmt = $this->db->query("SELECT COUNT(*) AS total FROM Cours WHERE professeur_id = ?", [$idTest]);
        $totalCours = $totalCoursStmt->fetch(\PDO::FETCH_ASSOC)['total'];

        // Récupération des données brutes du cours avec la pagination
        // Remarquez que LIMIT et OFFSET sont directement insérés dans la chaîne SQL
        $coursStmt = $this->db->query(
            "SELECT * FROM Cours WHERE professeur_id = ? LIMIT $itemsPerPage OFFSET $offset",
            [$idTest]
        );
        $coursResult = $coursStmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($coursResult) {
            $coursComplets = [];


            foreach ($coursResult as $cours) {
                // Récupération des informations supplémentaires
                $moduleStmt = $this->db->query("SELECT nom FROM Module WHERE id = ?", [$cours['module_id']]);
                $module = $moduleStmt->fetch(\PDO::FETCH_ASSOC);

                $semestreStmt = $this->db->query("SELECT numero FROM Semestre WHERE id = ?", [$cours['semestre_id']]);
                $semestre = $semestreStmt->fetch(\PDO::FETCH_ASSOC);

                $classeStmt = $this->db->query("SELECT nom FROM Classe WHERE id = ?", [$cours['classe_id']]);
                $classe = $classeStmt->fetch(\PDO::FETCH_ASSOC);

                $jourStmt = $this->db->query("SELECT nom FROM Jour WHERE id = ?", [$cours['jour_id']]);
                $jour = $jourStmt->fetch(\PDO::FETCH_ASSOC);

                $salleStmt = $this->db->query("SELECT nom FROM Salle WHERE id = ?", [$cours['salle_id']]);
                $salle = $salleStmt->fetch(\PDO::FETCH_ASSOC);

                $statusStmt = $this->db->query("SELECT nom FROM Status WHERE id = ?", [$cours['status_id']]);
                $status = $statusStmt->fetch(\PDO::FETCH_ASSOC);
 
                // Assemblage des informations complètes
                $coursComplets[] = [
                    'module' => $module['nom'],
                    'semestre' => $semestre['numero'],
                    'classe' => $classe['nom'],
                    'jour' => $jour['nom'],
                    'semaine' => $cours['semaine'],
                    'heure_debut' => $cours['heure_debut'],
                    'heure_fin' => $cours['heure_fin'],
                    'salle' => $salle['nom'],
                    'status' => $status['nom']
                ];
            }

            // Calcul du nombre de pages
            $totalPages = ceil($totalCours / $itemsPerPage);

            $this->renderView('cours', [
                'cours' => $coursComplets,
                'totalPages' => $totalPages,
                'currentPage' => $currentPage
            ]);
        } else {
            $this->renderView('cours', [
                'fetchError' => $fetchError
            ]);
        }
    }


    public function showPlanning()
    {
        // Récupération du numéro de la semaine et du semestre depuis les paramètres GET
        $semaine = isset($_GET['semaine']) ? (int) $_GET['semaine'] : 1;
        $semestre = isset($_GET['semestre']) ? (int) $_GET['semestre'] : 1;

        $fetchError = "Erreur de récupération des données";

        // Requête pour récupérer les cours pour la semaine et le semestre donnés
        $planningStmt = $this->db->query(
            "SELECT 
            j.nom AS jour,
            c.heure_debut,
            c.heure_fin,
            m.nom AS module,
            s.nom AS salle,
            cl.nom AS classe,
            st.nom AS status
        FROM 
            Cours c
        JOIN 
            Jour j ON c.jour_id = j.id
        JOIN 
            Module m ON c.module_id = m.id
        JOIN 
            Salle s ON c.salle_id = s.id
        JOIN 
            Classe cl ON c.classe_id = cl.id
        JOIN
            Status st ON c.status_id = st.id
        
        WHERE 
            c.semaine = ? AND c.semestre_id = ?
        -- ORDER BY 
            -- j.id, c.heure_debut",
            [$semaine, $semestre]
        );

        $planningResult = $planningStmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($planningResult) {
            $planning = [];
            foreach ($planningResult as $cours) {
                $jour = $cours['jour'];
                if (!isset($planning[$jour])) {
                    $planning[$jour] = [];
                }
                $planning[$jour][] = $cours;
            }

            $this->renderView('planning', [
                'planning' => $planning,
                'semaine' => $semaine,
                'semestre' => $semestre
            ]);
        } else {
            $this->renderView('planning', [
                'fetchError' => $fetchError
            ]);
        }
    }










}


//---- AFFICHAGES DES COURS SANS PAGINATION

/*
public function getProfessor()
    { 
        $idTest = 1;
        $fetchError = "Erreur recupération des données";
    
        // Récupération des données brutes du cours
        $coursStmt = $this->db->query("SELECT * FROM Cours WHERE professeur_id = ?", [$idTest]);
        $coursResult = $coursStmt->fetchAll(\PDO::FETCH_ASSOC);
    
        if ($coursResult) {
            $coursComplets = [];
    
            foreach ($coursResult as $cours) {
                // Récupération des informations supplémentaires
                $moduleStmt = $this->db->query("SELECT nom FROM Module WHERE id = ?", [$cours['module_id']]);
                $module = $moduleStmt->fetch(\PDO::FETCH_ASSOC);
    
                $semestreStmt = $this->db->query("SELECT numero FROM Semestre WHERE id = ?", [$cours['semestre_id']]);
                $semestre = $semestreStmt->fetch(\PDO::FETCH_ASSOC);
    
                $classeStmt = $this->db->query("SELECT nom FROM Classe WHERE id = ?", [$cours['classe_id']]);
                $classe = $classeStmt->fetch(\PDO::FETCH_ASSOC);
    
                $jourStmt = $this->db->query("SELECT nom FROM Jour WHERE id = ?", [$cours['jour_id']]);
                $jour = $jourStmt->fetch(\PDO::FETCH_ASSOC);
    
                $salleStmt = $this->db->query("SELECT nom FROM Salle WHERE id = ?", [$cours['salle_id']]);
                $salle = $salleStmt->fetch(\PDO::FETCH_ASSOC);
    
                $statusStmt = $this->db->query("SELECT nom FROM Status WHERE id = ?", [$cours['status_id']]);
                $status = $statusStmt->fetch(\PDO::FETCH_ASSOC);
    
                // Assemblage des informations complètes
                $coursComplets[] = [
                    'module' => $module['nom'],
                    'semestre' => $semestre['numero'],
                    'classe' => $classe['nom'],
                    'jour' => $jour['nom'],
                    'semaine' => $cours['semaine'],
                    'heure_debut' => $cours['heure_debut'],
                    'heure_fin' => $cours['heure_fin'],
                    'salle' => $salle['nom'],
                    'status' => $status['nom']
                ];
            }
    
            $this->renderView('cours', [
                'cours' => $coursComplets
            ]);
        } else {
            $this->renderView('cours', [
                'fetchError' => $fetchError
            ]);
        }
    }
    
    public function getProfessor($page = 1)
    {
        $idTest = 1;
        $fetchError = "Erreur recupération des données";
        $itemsPerPage = 3;
        $offset = ($page - 1) * $itemsPerPage;

        // Compter le nombre total de cours pour la pagination
        $totalCoursStmt = $this->db->query("SELECT COUNT(*) AS total FROM Cours WHERE professeur_id = ?", [$idTest]);
        $totalCours = $totalCoursStmt->fetch(\PDO::FETCH_ASSOC)['total'];


        // Récupération des données brutes du cours avec la pagination
        $coursStmt = $this->db->query("SELECT * FROM Cours WHERE professeur_id = ? LIMIT ? OFFSET ?", [$idTest, $itemsPerPage, $offset]);
        $coursResult = $coursStmt->fetchAll(\PDO::FETCH_ASSOC);


        if ($coursResult) {
            $coursComplets = [];

            foreach ($coursResult as $cours) {
                // Récupération des informations supplémentaires
                $moduleStmt = $this->db->query("SELECT nom FROM Module WHERE id = ?", [$cours['module_id']]);
                $module = $moduleStmt->fetch(\PDO::FETCH_ASSOC);

                $semestreStmt = $this->db->query("SELECT numero FROM Semestre WHERE id = ?", [$cours['semestre_id']]);
                $semestre = $semestreStmt->fetch(\PDO::FETCH_ASSOC);

                $classeStmt = $this->db->query("SELECT nom FROM Classe WHERE id = ?", [$cours['classe_id']]);
                $classe = $classeStmt->fetch(\PDO::FETCH_ASSOC);

                $jourStmt = $this->db->query("SELECT nom FROM Jour WHERE id = ?", [$cours['jour_id']]);
                $jour = $jourStmt->fetch(\PDO::FETCH_ASSOC);

                $salleStmt = $this->db->query("SELECT nom FROM Salle WHERE id = ?", [$cours['salle_id']]);
                $salle = $salleStmt->fetch(\PDO::FETCH_ASSOC);

                $statusStmt = $this->db->query("SELECT nom FROM Status WHERE id = ?", [$cours['status_id']]);
                $status = $statusStmt->fetch(\PDO::FETCH_ASSOC);

                // Assemblage des informations complètes
                $coursComplets[] = [
                    'module' => $module['nom'],
                    'semestre' => $semestre['numero'],
                    'classe' => $classe['nom'],
                    'jour' => $jour['nom'],
                    'semaine' => $cours['semaine'],
                    'heure_debut' => $cours['heure_debut'],
                    'heure_fin' => $cours['heure_fin'],
                    'salle' => $salle['nom'],
                    'status' => $status['nom']
                ];
            }

            $totalPages = ceil($totalCours / $itemsPerPage);

            $this->renderView('cours', [
                'cours' => $coursComplets,
                'totalPages' => $totalPages,
                'currentPage' => $page
            ]);
        } else {
            $this->renderView('cours', [
                'fetchError' => $fetchError
            ]);
        }
    }

    ERREUR NAVIGATEUR: 
Fatal error: Uncaught PDOException: SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax;
check the manual that corresponds to your MySQL server version for the right syntax to use near ''3' OFFSET '0'' at line 1
in /var/www/html/projet221/core/SecurityDatabase.php:41 Stack trace: #0 /var/www/html/projet221/core/SecurityDatabase.php(41):
PDOStatement->execute() #1 /var/www/html/projet221/app/Controllers/ProfController.php(30): Core\SecurityDatabase->query() #2
/var/www/html/projet221/core/Route.php(30): App\Controllers\ProfController->getProfessor() #3 /var/www/html/projet221/public/index.php(26):
Core\Route::run() #4 {main} thrown in /var/www/html/projet221/core/SecurityDatabase.php on line 41


    public function getProfessor()
    {
        $idTest = 1;
        $fetchError = "Erreur recupération des données";
    
        // Récupération des données brutes du cours
        $coursStmt = $this->db->query("SELECT * FROM Cours WHERE professeur_id = ?", [$idTest]);
        $coursResult = $coursStmt->fetchAll(\PDO::FETCH_ASSOC);
    
        if ($coursResult) {
            $coursComplets = [];
    
            foreach ($coursResult as $cours) {
                // Récupération des informations supplémentaires
                $moduleStmt = $this->db->query("SELECT nom FROM Module WHERE id = ?", [$cours['module_id']]);
                $module = $moduleStmt->fetch(\PDO::FETCH_ASSOC);
    
                $semestreStmt = $this->db->query("SELECT numero FROM Semestre WHERE id = ?", [$cours['semestre_id']]);
                $semestre = $semestreStmt->fetch(\PDO::FETCH_ASSOC);
    
                $classeStmt = $this->db->query("SELECT nom FROM Classe WHERE id = ?", [$cours['classe_id']]);
                $classe = $classeStmt->fetch(\PDO::FETCH_ASSOC);
    
                $jourStmt = $this->db->query("SELECT nom FROM Jour WHERE id = ?", [$cours['jour_id']]);
                $jour = $jourStmt->fetch(\PDO::FETCH_ASSOC);
    
                $salleStmt = $this->db->query("SELECT nom FROM Salle WHERE id = ?", [$cours['salle_id']]);
                $salle = $salleStmt->fetch(\PDO::FETCH_ASSOC);
    
                $statusStmt = $this->db->query("SELECT nom FROM Status WHERE id = ?", [$cours['status_id']]);
                $status = $statusStmt->fetch(\PDO::FETCH_ASSOC);
    
                // Assemblage des informations complètes
                $coursComplets[] = [
                    'module' => $module['nom'],
                    'semestre' => $semestre['numero'],
                    'classe' => $classe['nom'],
                    'jour' => $jour['nom'],
                    'semaine' => $cours['semaine'],
                    'heure_debut' => $cours['heure_debut'],
                    'heure_fin' => $cours['heure_fin'],
                    'salle' => $salle['nom'],
                    'status' => $status['nom']
                ];
            }
    
            $this->renderView('cours', [
                'cours' => $coursComplets
            ]);
        } else {
            $this->renderView('cours', [
                'fetchError' => $fetchError
            ]);
        }
    }


*/
