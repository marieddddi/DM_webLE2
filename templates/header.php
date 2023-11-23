<?php
// Si la page est appelée directement par son adresse, on redirige en passant par la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
	header("Location:../index.php");
	die("");
}

// Pose quelques soucis avec certains serveurs...
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
?>



<!-- **** H E A D **** -->

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Editeur de smiley</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">


	<script src="js/main.js"></script>
	<script src="js/jquery-3.7.1.js"></script>




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

</>
</head>

