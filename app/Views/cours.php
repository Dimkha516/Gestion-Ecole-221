<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles.css">
    <title>Document</title>
    <style>
        .pagination {
            margin: 20px 0;
            text-align: center;
        }

        .pagination a {
            margin: 0 5px;
            padding: 5px 10px;
            border: 1px solid #ddd;
            text-decoration: none;
            color: #333;
        }

        .pagination a.active {
            background-color: #333;
            color: white;
            border: 1px solid #333;
        }
    </style>
</head>

<body>
    <div class="main" style="text-align:center; margin-top:10px;">
        <?php if (isset($fetchError)): ?>
            <p style="color:tomato;font-weight:900"><?= $fetchError ?></p>
        <?php endif; ?>
        <div class="head" style="margin:20px; display:flex;justify-content:space-around;">
            <div class="filtres" style="display:flex; justify-content:space-around;">

                <div style="margin:20px;">
                    <label for="filtreJour">JOUR:</label>
                    <select class="select select-bordered w-full max-w-xs" name="filtreJours" id="filtreJour">
                        <option disabled selected>Filtrer par jour</option>
                        <option value="lundi">Lundi</option>
                        <option value="mardi">Mardi</option>
                        <option value="mercredi">Mercredi</option>
                        <option value="jeudi">Jeudi</option>
                        <option value="vendredi">Vendredi</option>
                        <!-- <option value=""></option>
                    <option value=""></option> -->
                    </select>
                </div>

                <div style="margin:20px;">

                    <label for="filtreSemaine">SEMAINE: </label>
                    <select class="select select-bordered w-full max-w-xs" name="filtreSemaine" id="filtreSemaine">
                        <option disabled selected>Filtrer par semaine</option>
                        <option value="1-14">1-14</option>
                        <option value="14-21">14-21</option>
                        <option value="21-28">21-28</option>
                        <option value="28-30">28-30</option>
                    </select>
                </div>
            </div>

            <div>
                <a href="/planning">
                    <button type="button" class="btn btn-primary" style="">Planning</button>
                </a>
            </div>

        </div>

        <div class="overflow-x-auto">
            <table class="table">
                <!-- head -->
                <thead style="background-color:gray;">
                    <tr>
                        <!-- <th></th> -->
                        <th style="font-size:2rem;">Module</th>
                        <th style="font-size:2rem;">Semestre</th>
                        <th style="font-size:2rem;">Classe</th>
                        <th style="font-size:2rem;">Jour</th>
                        <th style="font-size:2rem;">Semaine</th>
                    </tr>
                </thead>


                <tbody>
                    <?php if (!empty($cours)): ?>
                        <?php foreach ($cours as $index => $cour): ?>
                            <tr>
                                <!-- <td style="font-size:1.2rem;font-weight:900;"><php echo $index + 1; ?></td> -->
                                <td style="font-size:1.2rem;font-weight:900;"><?php echo htmlspecialchars($cour['module']); ?>
                                </td>
                                <td style="font-size:1.2rem;font-weight:900;"><?php echo htmlspecialchars($cour['semestre']); ?>
                                </td>
                                <td style="font-size:1.2rem;font-weight:900;"><?php echo htmlspecialchars($cour['classe']); ?>
                                </td>
                                <td style="font-size:1.2rem;font-weight:900;"><?php echo htmlspecialchars($cour['jour']); ?>
                                </td>
                                <td style="font-size:1.2rem;font-weight:900;"><?php echo htmlspecialchars($cour['semaine']); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Aucun cours trouvé.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <form method="post" action="/cours" style="display: inline;">
                        <input type="hidden" name="page" value="<?php echo $i; ?>">
                        <button type="submit" class="<?php echo $currentPage == $i ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </button>
                    </form>
                <?php endfor; ?>
            </div>

        </div>
    </div>
</body>

</html>