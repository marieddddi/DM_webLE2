<?php
include_once('libs/modele.php');

$nbCases = 3; // Nombre par défaut
$grille = '<table id="grille"> 
	<tr> 
		<td style="background-color: rgb(255, 255, 255);"></td> 
		<td style="background-color: rgb(255, 255, 255);"></td> 
		<td style="background-color: rgb(255, 255, 255);"></td> 
	</tr> 
	<tr> 
		<td style="background-color: rgb(255, 255, 255);"></td>
		<td style="background-color: rgb(255, 255, 255);"></td>
		<td style="background-color: rgb(255, 255, 255);"></td> 
	</tr> 
	<tr>
		<td style="background-color: rgb(255, 255, 255);"></td> 
		<td style="background-color: rgb(255, 255, 255);"></td> 
		<td style="background-color: rgb(255, 255, 255);"></td>  
	</tr> 
</table>';

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nbCases'])) {
	$nbCases = intval($_POST['nbCases']);

	// Valider le nombre de cases
	if ($nbCases >= 2 && $nbCases <= 20) {
		$grille = '<table id="grille">';
		for ($i = 0; $i < $nbCases; $i++) {
			$grille .= '<tr>';
			for ($j = 0; $j < $nbCases; $j++) {
				$grille .= '<td style="background-color: rgb(255, 255, 255);"></td>';
			}
			$grille .= '</tr>';
		}
		$grille .= '</table>';
	} else {
		$nbCases = 3; // Nombre par défaut si le nombre entré n'est pas valide
		$grille = '<p>Le nombre de cases doit être entre 2 et 20.</p>';
	}
}
?>

<style>
	table {
		margin-left: 20px;
		width: 30%;
		height: auto;
		border-collapse: collapse;
	}

	table td {
		border: 1px solid black;
		width: calc(100% /
				<?php echo $nbCases; ?>
			);
		height: 0;
		padding-bottom: calc(100% /
				<?php echo $nbCases; ?>
			);
		position: relative;
		background-color: #ccc;
	}

	table td::before {
		content: "";
		position: absolute;
		top: 0;
		bottom: 0;
		left: 0;
		right: 0;
	}
</style>


<!-- Formulaire pour sélectionner le nombre de cases de la grille de l'image -->
<form action="index.php?view=accueil" method="POST">
	<label for="nbCases">Nombre de cases : </label>
	<input type="number" name="nbCases" id="nbCases" min="2" max="20" value="<?php echo $nbCases; ?>" />
	<input type="submit" value="Valider" />
</form>



<!-- Affichage de la grille -->
<?php echo $grille; ?>

<h1> Ma palette de couleurs</h1> <br />

<!-- Affichage de la palette -->
<?php
function conversion_chaine($couleurs)
{
	// Explode la chaîne de couleurs en un tableau en utilisant la virgule comme séparateur
	$couleursArray = explode(',', $couleurs);

	// Nettoie le tableau des éventuels espaces vides ou valeurs vides
	$couleursArray = array_filter(array_map('trim', $couleursArray));

	// Retourne le tableau des couleurs
	return $couleursArray;
}


// Affichage du tableau de couleurs récupéré
$connecte = 0;
if (valider('connecte', 'SESSION') == false) {
	$palette = conversion_chaine("#ff0000,#00ffff,#000000,#8000ff,#abcdef,#ccbbaa");
} else {
	$connecte = 1;
	$couleurs = palette_mon_compte($_SESSION['idUser']);
	$palette = conversion_chaine($couleurs);
}
$i = 0;
echo '<div id="liste">';
foreach ($palette as $p) {
	if ($i == 3) {
		echo "<br>";
		$i = 0;
	}
	echo "<div class='color' style='background-color:" . $p . ";'></div>";
	$i++;
}
if ($connecte == 0) {
	echo "<div id=comptelien> <a href='index.php?view=login'> Personnaliser ma palette en me connectant ou en créant un compte </a> </div>";
}

?>

</div>

<!-- Selectionner une couleur dans la palette et cliquer sur une case pour en changer la couleur (JQerry) -->
<script>
	$(document).ready(function () {
		// Sélectionner une couleur dans la palette
		$(".color").click(function () {
			var selectedColor = $(this).css("background-color");
			$(".selected").removeClass("selected");
			$(this).addClass("selected");
		});

		// Changer la couleur de la case lors du clic
		$("table td").click(function () {
			if ($(".selected").length > 0) {
				var newColor = $(".selected").css("background-color");
				$(this).css("background-color", newColor);
			}
		});
	});
</script>


<button id="btn1" onclick="transforme();">Enregistrer</button>
<button id="btn2" onclick="enregistrePNG('petit');">Enregistrer en petit png</button>
<button id="btn3" onclick="enregistrePNG('moyen');">Enregistrer en moyen png</button>
<button id="btn4" onclick="enregistrePNG('grand');">Enregistrer en grand png</button>


<style>
	table {
		margin-left: 20px;
		width: 30%;
		height: auto;
		border-collapse: collapse;
	}

	table td {
		border: 1px solid black;
		width: calc(100% /
				<?php echo $nbCases; ?>
			);
		height: 0;
		padding-bottom: calc(100% /
				<?php echo $nbCases; ?>
			);
		position: relative;
		background-color: #ccc;
	}

	table td::before {
		content: "";
		position: absolute;
		top: 0;
		bottom: 0;
		left: 0;
		right: 0;
	}
</style>

<?php
// Affichage du tableau de smileys récupéré
if (valider('connecte', 'SESSION') == true) {
	$smileys = smileys_mon_compte($_SESSION['idUser']);
	echo "<div class='lessmiley'>"; // Conteneur pour les tableaux avec espacement
	foreach ($smileys as $s) {
		foreach ($s as $valeur) {
			$affichage = conversion_chaine($valeur);
			$taille = $affichage[0];
			$nb = 0;
			echo "<div class='table-container'>"; // Conteneur pour les tableaux avec espacement
			echo "<table class='smiley-table'>"; // Ouvre un tableau
			for ($i = 0; $i < $taille; $i++) {
				echo "<tr>"; // Nouvelle ligne pour chaque itération extérieure 
				for ($j = 0; $j < $taille; $j++) {
					echo "<td>";
					echo "<div class='pixel' style='background-color:" . $affichage[$nb + 1] . ";'></div>";
					echo "</td>";
					$nb++;
				}
				echo "</tr>"; // Ferme la ligne après avoir ajouté les éléments 
			}
			echo "</table>"; // Ferme le tableau à la fin de chaque itération 
			echo "</div>"; // Ferme le conteneur pour les tableaux
		}
	}
	echo "</div>";
}
?>