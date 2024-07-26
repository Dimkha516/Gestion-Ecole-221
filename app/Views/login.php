<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles.css">
    <title>Document</title>
</head>

<body>


    <form action="/login" method="POST" class="max-w-sm mx-auto"
        style="margin-top:50px;padding:30px;border:solid 2px white;border-radius:12px;">

        <div style="display:flex;justify-content:space-around;margin-bottom:50px;">

            <img src="passe.png" style="width:5vw;height:10vh;">
            <h1 style="font-size:2rem;color:white;margin-top:13px;">Connectez-vous</h1>
        </div>
        <?php if (isset($loginError)): ?>
            <p style="color:tomato;font-size:1.3rem;font-weight:900;text-align:center;"><?= $loginError ?></p>
        <?php endif; ?>
        <div class="mb-5">
            <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
            <input type="text" id="username" name="username"
                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="email@email.com" />
        </div>
        <div class="mb-5">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mot de
                passe</label>
            <input type="password" id="password" name="password"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
        </div>
        <button type="submit" style="margin-left:120px; padding:18px;"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Valider</button>

        <!-- <a href="/planning">
                <button type="button" style="margin-left:120px; padding:18px;"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Valider</button>
            </a> -->

    </form>

</body>

</html>