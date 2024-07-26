<?php
namespace App\Controllers;

use Core\Controller;
use Core\Validator;
use Core\SecurityDatabase;

class EtudiantController extends Controller
{
    private $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = new SecurityDatabase();
    }

    // public function getStudentCours($page = 1)
    public function getStudentCours($params = [])
    {
        $page = isset($params['page']) ? (int) $params['page'] : 1;
        $etudiantId = 1;
        $fetchError = "Erreur de récupération des données";
        $itemsPerPage = 10;
        $offset = ($page - 1) * $itemsPerPage;

        $etudiantStmt = $this->db->query(
            "SELECT nom, prenom FROM etudiants WHERE id = ?",
            [$etudiantId]
        );

        $etudiant = $etudiantStmt->fetch(\PDO::FETCH_ASSOC);
        // var_dump($etudiant);

        if (!$etudiant) {
            $this->renderView('etudiant', [
                'fetchError' => 'Etudiant non trouvé'
            ]);
            return;
        }

        // Compter le nombre total de cours pour la pagination
        $totalCoursStmt = $this->db->query(
            "SELECT COUNT(DISTINCT c.id) AS total
         FROM cours c
         JOIN sessions_de_cours sdc ON c.id = sdc.cours_id
         JOIN inscriptions i ON i.classe_id = (
             SELECT classe_id FROM inscriptions WHERE etudiant_id = ? LIMIT 1
         )",
            [$etudiantId]
        );
        $totalCours = $totalCoursStmt->fetch(\PDO::FETCH_ASSOC)['total'];

        // Récupération des données brutes du cours avec la pagination
        $coursStmt = $this->db->query(
            "SELECT c.id, m.libelle AS module, CONCAT(p.nom, ' ', p.prenom) AS professeur, c.nombre_heure_global AS nombre_heures
         FROM cours c
         JOIN modules m ON c.module_id = m.id
         JOIN sessions_de_cours sdc ON c.id = sdc.cours_id
         JOIN professeurs p ON sdc.professeur_id = p.id
         JOIN inscriptions i ON i.classe_id = (
             SELECT classe_id FROM inscriptions WHERE etudiant_id = ? LIMIT 1
         )
         GROUP BY c.id, m.libelle, p.nom, p.prenom, c.nombre_heure_global
         LIMIT $itemsPerPage OFFSET $offset",
            [$etudiantId]
        );
        $coursResult = $coursStmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($coursResult) {
            // Calcul du nombre de pages
            $totalPages = ceil($totalCours / $itemsPerPage);


            $this->renderView('etudiant', [
                'cours' => $coursResult,
                'totalPages' => $totalPages,
                'currentPage' => $page,
                'etudiant' => $etudiant
            ]);

        } else {
            $this->renderView('etudiant', [
                'fetchError' => $fetchError
            ]);
        }
    }

    public function getStudentSessions()
    {
        $studentId = 1; // Remplacez ceci par l'ID de l'étudiant courant
        $fetchError = "Erreur de récupération des données";


        // Préparez la requête SQL
        $sql = "
        SELECT s.date, s.heure_debut, s.heure_fin, s.status, m.libelle AS module_libelle, 
               p.nom AS professeur_nom, p.prenom AS professeur_prenom, 
               sa.nom AS salle_nom,
               j.nom AS jour_nom
        FROM sessions_de_cours s
        JOIN Jour j ON s.jour_id = j.id
        JOIN cours c ON s.cours_id = c.id
        JOIN modules m ON c.module_id = m.id
        JOIN professeurs p ON s.professeur_id = p.id
        JOIN salles sa ON s.salle_id = sa.id
        JOIN inscriptions i ON i.classe_id = (
            SELECT classe_id FROM inscriptions WHERE etudiant_id = ? LIMIT 1
        )
        WHERE s.cours_id = c.id
        ORDER BY s.date, s.heure_debut
    ";

        // Exécuter la requête
        $sessionsStmt = $this->db->query($sql, [$studentId]);
        $sessions = $sessionsStmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($sessions) {
            $planning = [];
            foreach ($sessions as $cours) {
                $jour = $cours['jour_nom'];
                if (!isset($planning[$jour])) {
                    $planning[$jour] = [];
                }
                $planning[$jour][] = $cours;
            }
            // var_dump($sessions);


            // Passer les données à la vue
            $this->renderView('sessionsEtudiant', [
                'planning' => $planning
            ]);
        } else {
            $this->renderView('sessionsEtudiant', [
                'fetchError' => $fetchError
            ]);
        }



        // Passer les données à la vue
        // $this->renderView('sessionsEtudiant', [
        //     'sessions' => $sessions,
        //     'planning' => $planning
        // ]);
    }


    public function getStudentAbsences()
    {
        $studentId = 1;

        $fetchError = "Erreur recupération des données";

        $sql = "SELECT * FROM absences WHERE etudiant_id = ?";

        $absencesStmt = $this->db->query($sql, [$studentId]);
        $absences = $absencesStmt->fetchAll(\PDO::FETCH_ASSOC);

        $absencesSql = "SELECT COUNT(id) FROM absences WHERE etudiant_id = ?";
        
        $nombreAbsenceStmt = $this->db->query($absencesSql, [$studentId]);
        $nombreAbsence = $nombreAbsenceStmt->fetchAll(\PDO::FETCH_ASSOC);
        // var_dump($nombreAbsence);

        if ($absences) {
            // var_dump($absences);
            $this->renderView('absences', [
                'absences' => $absences,
                'nombreAbsence' => $nombreAbsence
            ]);
        } else {
            var_dump($fetchError);
            $this->renderView('absences', [
                'fetchError' => $fetchError
            ]);
        }
    }




}
