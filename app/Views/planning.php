<!DOCTYPE html>
<html>
<link rel="stylesheet" href="/styles.css">

<head>
    <title>Planning des Cours</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            vertical-align: top;
        }

        th {
            background-color: gray;
            color: white;
            text-align: center;
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

        .calendar-cell {
            min-height: 100px;
        }

        .course {
            padding: 5px;
            margin: 5px 0;
        }

        .course .details {
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="main" style="text-align:center; margin-top:10px;">

        <a href="/cours">
            <button type="button" class="btn btn-primary" style="">Accueil</button>
        </a>

        <div class="headers" style="margin:10px; display:flex;justify-content:space-around;">

            <div>
                <label for="sessionMois">MOIS</label>
                <select class="select select-bordered w-full max-w-xs" name="sessionMois" id="sessionMois">
                    <option disabled selected>Choisir le mois</option>
                    <option value="janvier">Janvier</option>
                    <option value="fevrier">Fevrier</option>
                    <option value="mars">Mars</option>
                    <option value="avril">Avril</option>
                    <option value="mai">Mai</option>
                </select>
            </div>

            <form method="GET" action="/planning">
                <label for="semaine">Sélectionnez la semaine:</label>
                <select class="select select-bordered w-full max-w-xs" name="semaine" id="semaine"
                    onchange="this.form.submit()">
                    <?php for ($i = 1; $i <= 52; $i++): ?>
                        <option value="<?php echo $i; ?>" <?php echo ($i == $semaine) ? 'selected' : ''; ?>><?php echo $i; ?>
                        </option>
                    <?php endfor; ?>
                </select>
                <input type="hidden" name="semestre" value="<?php echo htmlspecialchars($semestre); ?>">
            </form>

            <div>
                <label for="statusSession">Status</label>
                <select class="select select-bordered w-full max-w-xs" name="statusSession" id="statusSession">
                    <option value="fait">Effectuée</option>
                    <option value="attente">A venir</option>
                    <option value="annule">Annulée</option>
                </select>
            </div>
        </div>



        <h1>Planning de la Semaine <?php echo htmlspecialchars($semaine); ?> du Semestre
            <?php echo htmlspecialchars($semestre); ?>
        </h1>
        <form method="GET" action="/planning">
            <label for="semaine">Sélectionnez la semaine:</label>
            <select name="semaine" id="semaine" onchange="this.form.submit()">
                <?php for ($i = 1; $i <= 52; $i++): ?>
                    <option value="<?php echo $i; ?>" <?php echo ($i == $semaine) ? 'selected' : ''; ?>><?php echo $i; ?>
                    </option>
                <?php endfor; ?>
            </select>
            <input type="hidden" name="semestre" value="<?php echo htmlspecialchars($semestre); ?>">
        </form>
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
                foreach ($hours as $hour):?>
                    <tr>
                        <td><?php echo $hour; ?></td>
                        <?php foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'] as $day): ?>
                            <td class="calendar-cell">
                                <?php if (isset($planning[$day])): ?>
                                    <?php foreach ($planning[$day] as $cours): ?>
                                        <?php if (strpos($cours['heure_debut'], $hour) === 0): ?>
                                            <div class="course <?php echo 'status-' . str_replace(' ', '-', $cours['status']); ?>">
                                                <strong><?php echo htmlspecialchars($cours['module']); ?></strong>
                                                <div class="details">
                                                    <?php echo htmlspecialchars($cours['heure_debut']) . '-' . htmlspecialchars($cours['heure_fin']); ?><br>
                                                    <?php echo htmlspecialchars($cours['salle']); ?><br>
                                                    <?php echo htmlspecialchars($cours['classe']); ?><br>
                                                    <span
                                                        class="<?php echo 'status-' . str_replace(' ', '-', $cours['status']); ?>"><?php echo htmlspecialchars($cours['status']); ?></span>
                                                </div>
                                                <?php if ($cours['status'] === 'a venir'): ?>
                                                    <button type="button" class="btn btn-primary" onclick="my_modal_1.showModal()">
                                                        Reprogrammer</button>
                                                <?php endif; ?>
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
    <dialog id="my_modal_1" class="modal">
        <div class="modal-box" style=" background-color:aliceblue; color:black; padding:20px; font-weight:900;">
            <a href="/cours">
                <button type="button" class="btn btn-primary" style="">Accueil</button>
            </a>
            <p class="py-4">Demande d'annulation et reprogrammation session de cours</p>

            <div class="head" style="display:flex;justify-content:space-around;margin:30px;border:solid 2px gray;">
                <div class="left">
                    <h2>JOUR: 02/11/2024</h2>
                    <h2>Début: 8:00</h2>
                    <h2>Fin: 10:00</h2>
                </div>
                <div class="right">
                    <h2>Module: JAVASCRIPT</h2>
                    <h2>SALLE: 1</h2>
                    <h2>Classe: Licence1</h2>
                </div>
            </div>

            <h2 style="text-align:center;margin:20px;">REPROGRAMMER</h2>

            <form action="" style="text-align:center; margin-top:20px">
                <div style="padding:10px; display:flex;justify-content:space-around;">
                    <label for="newDate">Date:</label>
                    <input type="date" id="newDate" name="newDate" style="width:15vw;" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    <!-- <input type="date" name="newDate" id="newDate"> -->
                </div>

                <div style="padding:10px; display:flex;justify-content:space-around;">
                    <label for="newTime">Heure: </label>
                    <input type="time" id="newTime" name="newTime" style="width:15vw;" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <button type="submit" class="btn btn-primary">Valider</button>
            </form>



            <div class="modal-action">
                <form method="dialog">
                    <!-- if there is a button in form, it will close the modal -->
                    <button class="btn">Fermer</button>
                </form>
            </div>
        </div>
    </dialog>
</body>

</html>