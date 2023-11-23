<?php
// Si la page est appelée directement par son adresse, on redirige en passant par la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
	header("Location:../index.php");
	die("");
}

// Pose quelques soucis avec certains serveurs...
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
?>


<!DOCTYPE html>
<html lang="fr">

<!-- **** H E A D **** -->

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Les recettes du chef</title>
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<!-- **** F I N **** H E A D **** -->



<!-- **** B O D Y **** -->

<body>

	<div id="banniere">
		<div id="image_gauche">
			<div id="logo">
				<a href="index.php?view=accueil">
					<img src="ressources/logo.png" alt="Logo" />
				</a>
			</div>
		</div>

		<div id="accueil">
			<a href="index.php?view=accueil">Accueil</a>
		</div>


		<div id="secoco">

			<?php if (!(isset($_SESSION['id_pers'])) && valider("connecte", "SESSION")): ?>
				<div id="moncompte" class="text">
					<a href="index.php?view=mon_compte" class="text">
						<span>Mon compte</span>
					</a>
				</div>
				<a href="controleur.php?action=Logout" class="text">
					<span>Se déconnecter</span>
				</a>
			<?php else: ?>
				<a href="index.php?view=login" class="text">
					<span>Se connecter</span>
				</a>
			<?php endif; ?>
		</div>
	</div>

</body>

<!-- **** F I N **** B O D Y **** -->

</html>