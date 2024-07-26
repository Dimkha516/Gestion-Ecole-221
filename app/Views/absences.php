<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/styles.css">
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
						foreground: 'hsl(var(--foreground))',< link rel="stylesheet" href="/styles.css" >
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
	<div class="bg-background p-6 rounded-lg shadow-md">
		<h1 class="text-2xl font-bold mb-4">Mes absences</h1>

		<div class="flex justify-between items-center mb-4">
			<div class="flex items-center">
				<label for="semester" class="mr-2">Semestre:</label>
				<select id="semester" class="border border-border rounded p-1">
					<option>Semestre1</option>
					<option>Semestre2</option>
				</select>
			</div>
			<div class="text-lg font-semibold">
				<!-- <php if(isset($nombreAbsence)): ?> -->
				<!-- <php echo ($nombreAbsence) ?>  -->
				<!-- Nb absences: <span class="text-primary"><= $nombreAbsence ?></span> -->
				<!-- <php endif ?> -->
				Nb absences: <span class="text-primary">6</span>
			</div>
			<a href="/etudiant">
				<button class="bg-secondary text-secondary-foreground p-2 rounded">Accueil</button>
			</a>
		</div>

		<table class="min-w-full border border-border">

			<thead>
				<tr class="bg-muted">
					<th class="border border-border p-2">Date</th>
					<th class="border border-border p-2">Module</th>
					<th class="border border-border p-2">Etat</th>
					<th class="border border-border p-2">Motif</th>
					<th class="border border-border p-2">Action</th>
				</tr>
			</thead>
			<tbody>
				<!-- <tr>
						<td class="border border-border p-2">Modélisation</td>
						<td class="border border-border p-2">10/07/2024</td>
						<td class="border border-border p-2">
							<button class="bg-accent text-accent-foreground p-1 rounded">Justifier</button>
						</td>
					</tr> -->
				<?php if (isset($absences)): ?>
					<?php foreach ($absences as $absence): ?>
						<tr>
							<td class="border border-border p-2"><?= $absence['date'] ?></td>
							<td class="border border-border p-2"><?= $absence['session_de_cours_id'] ?></td>
							
							<td class="border border-border" style="color:green;font-size:1.2rem;">
								<?php if($absence['justifiee'] == '1'):?>
									Justifié
								<?php endif;?>
							</td>
							
							<td class="border border-border"><?= $absence['motif_justification'] ?></td>
							
							<td class="border border-border">
							    <?php if($absence['justifiee'] == '0'):?>
									<a href="">

									</a>
									<button class="btn" onclick="my_modal_1.showModal()">Justifier</button>
								<?php endif; ?>		
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
	<!-- Open the modal using ID.showModal() method -->
	<!-- <button class="btn" onclick="my_modal_1.showModal()">open modal</button> -->
	<dialog id="my_modal_1" class="modal">
		<div class="modal-box">
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
				<div class="bg-background p-6 rounded-lg shadow-lg">
					<div class="flex justify-between items-center mb-4">
						<a href="/etudiant">
							<button class="bg-secondary text-secondary-foreground px-4 py-2 rounded-lg">Accueil</button>
						</a>
					</div>
					<h1 class="text-2xl font-bold mb-4">Justification absence du 10/07/2024</h1>
					<label class="block text-lg mb-2" for="motif">Motif:</label>
					<input type="text" id="motif" class="border border-border rounded-lg p-2 w-full mb-4"
						placeholder="Entrez le motif" />
					<button
						class="bg-secondary text-secondary-foreground hover:bg-secondary/80 px-4 py-2 rounded-lg">Envoyer</button>
				</div>
			</body>

			</html>
			<div class="modal-action">
				<form method="dialog">
					<!-- if there is a button in form, it will close the modal -->
					<button class="btn">Close</button>
				</form>
			</div>
		</div>
	</dialog>
</body>

</html>