<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script src="https://unpkg.com/unlazy@0.11.3/dist/unlazy.with-hashing.iife.js" defer init></script>
    <script type="text/javascript">
        window.tailwind.config = {
            darkMode: ['class'],
            theme: {
                extend: {
                    colors: {
                        border: 'hsl(var(--border))', 
                        input: 'hsl(var(--input))',
                        ring: 'hsl(var(--ring))',
                        background: 'hsl(var(--background))',
                        foreground: 'hsl(var(--foreground))',
                        primary: {
                            DEFAULT: 'hsl(var(--primary))',
                            foreground: 'hsl(var(--primary-foreground))'
                        },
                        secondary: {
                            DEFAULT: 'hsl(var(--secondary))',
                            foreground: 'hsl(var(--secondary-foreground))'
                        },
                        destructive: {
                            DEFAULT: 'hsl(var(--destructive))',
                            foreground: 'hsl(var(--destructive-foreground))'
                        },
                        muted: {
                            DEFAULT: 'hsl(var(--muted))',
                            foreground: 'hsl(var(--muted-foreground))'
                        },
                        accent: {
                            DEFAULT: 'hsl(var(--accent))',
                            foreground: 'hsl(var(--accent-foreground))'
                        },
                        popover: {
                            DEFAULT: 'hsl(var(--popover))',
                            foreground: 'hsl(var(--popover-foreground))'
                        },
                        card: {
                            DEFAULT: 'hsl(var(--card))',
                            foreground: 'hsl(var(--card-foreground))'
                        },
                    },
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer base {
                :root {
                    --background: 0 0% 100%;
--foreground: 240 10% 3.9%;
--card: 0 0% 100%;
--card-foreground: 240 10% 3.9%;
--popover: 0 0% 100%;
--popover-foreground: 240 10% 3.9%;
--primary: 240 5.9% 10%;
--primary-foreground: 0 0% 98%;
--secondary: 240 4.8% 95.9%;
--secondary-foreground: 240 5.9% 10%;
--muted: 240 4.8% 95.9%;
--muted-foreground: 240 3.8% 46.1%;
--accent: 240 4.8% 95.9%;
--accent-foreground: 240 5.9% 10%;
--destructive: 0 84.2% 60.2%;
--destructive-foreground: 0 0% 98%;
--border: 240 5.9% 90%;
--input: 240 5.9% 90%;
--ring: 240 5.9% 10%;
--radius: 0.5rem;
                }
                .dark {
                    --background: 240 10% 3.9%;
--foreground: 0 0% 98%;
--card: 240 10% 3.9%;
--card-foreground: 0 0% 98%;
--popover: 240 10% 3.9%;
--popover-foreground: 0 0% 98%;
--primary: 0 0% 98%;
--primary-foreground: 240 5.9% 10%;
--secondary: 240 3.7% 15.9%;
--secondary-foreground: 0 0% 98%;
--muted: 240 3.7% 15.9%;
--muted-foreground: 240 5% 64.9%;
--accent: 240 3.7% 15.9%;
--accent-foreground: 0 0% 98%;
--destructive: 0 62.8% 30.6%;
--destructive-foreground: 0 0% 98%;
--border: 240 3.7% 15.9%;
--input: 240 3.7% 15.9%;
--ring: 240 4.9% 83.9%;
                }
            }
        </style>
</head>

<body>


    <div class="flex flex-col bg-background p-6 rounded-lg shadow-lg">
        <div class="flex items-center mb-4">
            <img src="https://openui.fly.dev/openui/24x24.svg?text=👤" alt="User Avatar"
                class="w-12 h-12 rounded-full mr-4" />
            <div>
                <h1 class="text-xl font-bold">Mamadou Diop</h1>
                <p class="text-muted-foreground">L2 Informatique</p>
            </div>
        </div>
        <div class="flex space-x-4 mb-4">
            <button class="bg-secondary text-secondary-foreground p-2 rounded-lg">Emarger</button>
            <a href="/sessionsEtudiant">
                <button class="bg-secondary text-secondary-foreground p-2 rounded-lg">Planning cours</button>
            </a>
            <a href="/absences">
                <button class="bg-secondary text-secondary-foreground p-2 rounded-lg">Absences</button>
            </a>
        </div>
        <h2 class="text-lg font-semibold mb-2">Liste de mes cours</h2>
        <?php if (isset($fetchError)): ?>
            <p><?= $fetchError ?></p>
        <?php else: ?>
            <table class="min-w-full bg-card">
                <thead>

                    <tr>
                        <th class="border-b border-muted p-2">Module</th>
                        <th class="border-b border-muted p-2">Professeur</th>
                        <th class="border-b border-muted p-2">Nbr heures</th>
                        <!-- <th class="border-b border-muted p-2">Nbr heures</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cours as $cour): ?>
                        <tr>
                            <td class="border-b border-muted p-2"><?= htmlspecialchars($cour['module']) ?></td>
                            <td class="border-b border-muted p-2"><?= htmlspecialchars($cour['professeur']) ?></td>
                            <td class="border-b border-muted p-2"><?= htmlspecialchars($cour['nombre_heures']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <!-- <tr>
                        <td class="border-b border-muted p-2">Modélisation</td>
                        <td class="border-b border-muted p-2">Mdm Sarr</td>
                        <td class="border-b border-muted p-2">12</td>
                        <td class="border-b border-muted p-2">Modélisation</td>
                    </tr>
                    <tr>
                        <td class="border-b border-muted p-2">Html/Css</td>
                        <td class="border-b border-muted p-2">Mrs Faye</td>
                        <td class="border-b border-muted p-2">10</td>
                        <td class="border-b border-muted p-2">Html/Css</td>
                    </tr>
                    <tr>
                        <td class="border-b border-muted p-2">JS</td>
                        <td class="border-b border-muted p-2">Mrs Diop</td>
                        <td class="border-b border-muted p-2">20</td>
                        <td class="border-b border-muted p-2">JS</td>
                    </tr> -->
                </tbody>
            </table>
            <div class="flex justify-center mt-4">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?= $i ?>"><?= $i ?></a>
                <?php endfor; ?>
                <!-- <button class="bg-primary text-primary-foreground p-2 rounded-lg">1</button>
                <button class="bg-primary text-primary-foreground p-2 rounded-lg">2</button>
                <button class="bg-primary text-primary-foreground p-2 rounded-lg">3</button> -->
            </div>
        </div>
    <?php endif; ?>


</body>

</html>