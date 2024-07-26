<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles.css">
    <title>Document</title>

    <style>
        .status-effectue {
            color: rgb(97, 255, 0);
        }

        .status-a-venir {
            color: rgb(251, 255, 0 );
        }

        .status-annule {
            color: rgb(255, 0, 0); 
        }
    </style>


</head>

<body>
    <div class="main" style="text-align:center; margin-top:10px;">

        <a href="/cours">
            <button type="button" class="btn btn-primary" style="">Accueil</button>
        </a>

        <div class="headers" style="margin:20px; display:flex;justify-content:space-around;">

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


            <!-- <div>
                <label for="sessionSemaine">SEMAINE: </label>
                <select class="select select-bordered w-full max-w-xs" name="" id="">
                    <option value="1">1-7</option>
                    <option value="2">7-14</option>
                    <option value="3">14-21</option>
                    <option value="4">21-31</option>
                </select>
            </div> -->
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

        <h1 style="font-size:1.5rem;font-weight:900;color:tomato;margin:20px;">Planning de la Semaine
            <?php echo htmlspecialchars($semaine); ?> du Semestre
            <?php echo htmlspecialchars($semestre); ?>
        </h1>

        <div class="overflow-x-auto">
            <table class="table">
                <thead style="background-color:darkblue;">
                    <tr>
                        <th style="font-size:2rem;">Jours</th>
                        <th style="font-size:2rem;"></th>
                        <th style="font-size:2rem;"></th>
                        <th style="font-size:2rem;"></th>
                        <th style="font-size:2rem;"></th>
                        <th style="font-size:2rem;"></th>
                        <th style="font-size:2rem;"></th>
                        <th style="font-size:2rem;"></th>
                        <th style="font-size:2rem;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($planning) && !empty($planning)): ?>
                        <?php foreach ($planning as $jour => $coursList): ?>
                            <?php foreach ($coursList as $cours): ?>
                                <?php
                                $statusClass = '';
                                switch ($cours['status']) {
                                    case 'effectue':
                                        $statusClass = 'status-effectue';
                                        break;
                                    case 'a venir':
                                        $statusClass = 'status-a-venir';
                                        break;
                                    case 'annule':
                                        $statusClass = 'status-annule';
                                        break;
                                }
                                ?>
                                <tr style="background-color:rgb(99, 99, 94);">
                                    <td style="font-size:1.2rem;font-weight:900;background-color:teal;">
                                        <?php echo htmlspecialchars($jour); ?>
                                    </td>
                                    <td style="font-size:1.2rem;font-weight:900;">
                                        <?php echo htmlspecialchars($cours['heure_debut']); ?>
                                    </td>
                                    <td style="font-size:1.2rem;font-weight:900;">
                                        <?php echo htmlspecialchars($cours['heure_fin']); ?>
                                    </td>
                                    <td style="font-size:1.2rem;font-weight:900;"><?php echo htmlspecialchars($cours['module']); ?>
                                    </td>
                                    <td style="font-size:1.2rem;font-weight:900;"><?php echo htmlspecialchars($cours['salle']); ?>
                                    </td>
                                    <td style="font-size:1.2rem;font-weight:900;"><?php echo htmlspecialchars($cours['classe']); ?>
                                    </td>

                                    <td style="font-size:1.2rem;font-weight:900;" class="<?php echo $statusClass; ?>">
                                        <?php echo htmlspecialchars($cours['status']); ?>
                                    </td>
                                    <td>
                                    <td>
                                        <?php if ($cours['status'] === 'a venir'): ?>

                                            <button type="button" class="btn btn-primary"
                                                onclick="my_modal_1.showModal()">Reprogrammer</button>
                                        <?php endif; ?>

                                    </td>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6"><?php echo htmlspecialchars($fetchError); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>


    </div>
    <!-- Open the modal using ID.showModal() method -->

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

La pagination de la page liste des cours ne marche pas je te donne le contenu de chaque fichier:
