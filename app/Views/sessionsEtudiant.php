<!-- app/Views/sessionsEtudiant.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles.css">
    <title>Calendrier des Sessions de Cours</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .calendar {
            display: flex;
            flex-wrap: wrap;
        }

        .day {
            width: 20%;
            /* 100% / 5 jours = 20% */
            border: 1px solid #ddd;
            box-sizing: border-box;
            padding: 5px;
            min-height: 100px;
            vertical-align: top;
        }

        .day-header {
            background-color: #f2f2f2;
            padding: 5px;
            font-weight: bold;
        }

        .session {
            margin-bottom: 5px;
            padding: 3px;
            background-color: #e0e0e0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .session.effectue {
            color: green;
        }

        .session.annule {
            color: red;
        }

        .session.a-venir {
            color: orange;
        }

        .status-effectue {
            color: rgb(117, 249, 0);
        }

        .status-a-venir {
            color: yellow;
        }

        .status-annule {
            color: red;
        }
    </style>
</head>

<body>
    <div style="display:flex;justify-content:space-around;margin:20px;">

        <h1>Calendrier des Sessions de Cours</h1>
        <a href="/etudiant">
            <button class="bg-secondary text-secondary-foreground px-4 py-2 rounded-lg">Accueil</button>
        </a>
    </div>
    <div class="calendar">
        <table>
            <thead>
                <tr>
                    <th>Heure</th>
                    <th>Lundi</th>
                    <th>Mardi</th>
                    <th>Mercredi</th>
                    <th>Jeudi</th>
                    <th>Vendredi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $hours = ["08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00"];
                foreach ($hours as $hour): ?>
                    <tr>
                        <td><?php echo $hour; ?></td>
                        <?php foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'] as $day): ?>
                            <td class="calendar-cell">
                                <?php if (isset($planning[$day])): ?>
                                    <?php foreach ($planning[$day] as $cours): ?>
                                        <?php if (strpos($cours['heure_debut'], $hour) === 0): ?>
                                            <div class="course <?php echo 'status-' . str_replace(' ', '-', $cours['status']); ?>">
                                                <strong><?php echo htmlspecialchars($cours['module_libelle']); ?></strong>
                                                <strong><?php echo htmlspecialchars($cours['date']); ?></strong>

                                                <div class="details">
                                                    <?php echo htmlspecialchars($cours['heure_debut']) . '-' . htmlspecialchars($cours['heure_fin']); ?><br>
                                                    <?php echo htmlspecialchars($cours['salle_nom']); ?><br>
                                                    <span
                                                        class="<?php echo 'status-' . str_replace(' ', '-', $cours['status']); ?>"><?php echo htmlspecialchars($cours['status']); ?></span>

                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>


<!-- <php
        $daysOfWeek = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
        $currentMonth = date('n'); // Mois actuel
        $currentYear = date('Y'); // Année actuelle

        try {
            $startDate = new DateTime("first day of $currentYear-$currentMonth");
            $endDate = new DateTime("last day of $currentYear-$currentMonth");
        } catch (Exception $e) {
            echo 'Erreur de date: ' . $e->getMessage();
            exit;
        }

        // Afficher les jours de la semaine
        echo '<div class="day-header">' . implode('</div><div class="day-header">', $daysOfWeek) . '</div>';
        
        // Ajouter des jours vides avant le début du mois
        $firstDayOfWeek = $startDate->format('N'); // 1 (Lun) à 7 (Dim)
        echo '<div class="day">' . str_repeat('&nbsp;', $firstDayOfWeek - 1) . '</div>';

        $currentDate = $startDate;
        while ($currentDate <= $endDate) {
            // Afficher les sessions pour chaque jour
            echo '<div class="day">';
            echo '<strong>' . $currentDate->format('j') . '</strong>';
            
            foreach ($sessions as $session) { 
                if ($session['date'] == $currentDate->format('Y-m-d')) {
                    $statusClass = strtolower(str_replace(' ', '-', $session['status']));
                    echo '<div class="session ' . $statusClass . '">';
                    echo '<strong>' . $session['module_libelle'] . '</strong><br>';
                    echo 'Prof: ' . $session['professeur_nom'] . ' ' . $session['professeur_prenom'] . '<br>';
                    echo 'Heure: ' . $session['heure_debut'] . ' - ' . $session['heure_fin'] . '<br>';
                    echo 'Salle: ' . $session['salle_nom'] . '<br>';
                    echo 'Statut: ' . $session['status'];
                    echo '</div>';
                }
            } 
            
            echo '</div>';
            $currentDate->modify('+1 day');
        }
        ?> -->