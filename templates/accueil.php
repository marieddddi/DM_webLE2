<?php
include_once("libs/modele.php");
include_once("libs/maLibForms.php");

$nbCases = 10; // Nombre par défaut
$grille = '';

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
		$nbCases = 10; // Nombre par défaut si le nombre entré n'est pas valide
		$grille = '<p>Le nombre de cases doit être entre 2 et 20.</p>';
	}
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Smiley</title>
	<link rel="stylesheet" type="text/css" href="css/accueil.css" />

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

</head>

<body>
	<!-- Formulaire pour sélectionner le nombre de cases de la grille de l'image -->
	<form action="index.php?view=accueil" method="POST">
		<label for="nbCases">Nombre de cases : </label>
		<input type="number" name="nbCases" id="nbCases" min="2" max="20" value="<?php echo $nbCases; ?>" />
		<input type="submit" value="Valider" />
	</form>

	<!-- Affichage de la grille -->
	<?php echo $grille; ?>

	<!-- Affichage de la palette -->
	<div id="liste">
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
		valider('connecte', 'SESSION');
		$couleurs = palette_mon_compte($_SESSION['idUser']);
		$palette = conversion_chaine($couleurs);
		foreach ($palette as $p) {
			echo "<div class='color' style='background-color:" . $p . ";'></div>";
		}

		?>
	</div>

	<!-- Selectionner une couleur dans la palette et cliquer sur une case pour en changer la couleur (JQerry) -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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



	<script>
		const pixelTable = document.getElementById("grille");

		function rgb2hex(rgb) {
			if (/^#[0-9A-F]{6}$/i.test(rgb)) return rgb;

			rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

			function hex(x) {
				return ("0" + parseInt(x).toString(16)).slice(-2);
			}
			return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
		}

		function obtenirChaineCouleurs() {
			var tableau = document.getElementById('grille');
			var cellules = tableau.getElementsByTagName('td');
			var chaine = Math.sqrt(cellules.length) + ",";

			for (let i = 0; i < cellules.length; i++) {
				var couleur = window.getComputedStyle(cellules[i]).getPropertyValue('background-color');
				couleur = rgb2hex(couleur);
				chaine += couleur + ",";
			}

			return chaine.substring(0, chaine.length - 1);
		}

		function transforme() {
			var chaine = obtenirChaineCouleurs();
			console.log(chaine);

		}

		function enregistrePNG(taille) {
			convertToImageAndDownload(obtenirChaineCouleurs(), taille);
		}


		function convertToImageAndDownload(chaineCouleurs, taille) {
			var largeur = Math.sqrt(chaineCouleurs.split(',').length - 1); // Obtenez la largeur de l'image depuis la chaîne
			var canvas = document.createElement('canvas');
			var tailleCanvas = 0;

			if (taille === "petit") {
				tailleCanvas = 100;
			} else if (taille === "grand") {
				tailleCanvas = 1000;
			}

			var ratio = tailleCanvas / largeur; // Calculer le ratio de redimensionnement
			var tailleImage = largeur * ratio;

			canvas.width = tailleImage;
			canvas.height = tailleImage;
			var context = canvas.getContext('2d');

			// Parcourir les couleurs et les appliquer aux pixels du canvas
			var couleurs = chaineCouleurs.split(',');
			couleurs = couleurs.slice(1); // Ignorer la première valeur (la largeur)
			for (var i = 0; i < couleurs.length; i++) {
				var x = (i % largeur) * ratio;
				var y = Math.floor(i / largeur) * ratio;
				var couleur = couleurs[i];
				couleur = couleur.replace('#', '');
				couleur = '#' + couleur; // Rétablir la notation hexadécimale
				context.fillStyle = couleur;
				context.fillRect(x, y, ratio, ratio); // Redimensionner le dessin du pixel
			}

			// Créer une image à partir du canvas
			var image = canvas.toDataURL("image/png");

			// Créer un lien pour télécharger l'image
			var a = document.createElement('a');
			a.href = image;
			a.download = 'image_' + Date.now() + '.png';
			a.click();
		}

	</script>

</body>

</html>