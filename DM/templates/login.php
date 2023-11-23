<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
	header("Location:../index.php?view=login");
	die("");
}

// Chargement eventuel des données en cookies
$login = valider("login", "COOKIE");
$passe = valider("passe", "COOKIE");

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<!-- **** H E A D **** -->

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Smiley</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<!-- **** F I N **** H E A D **** -->


<!-- **** B O D Y **** -->

<body>
	<div id="corps">
		<div id="image">
			<img src="ressources/compte.jpg" />
		</div>
		<p id="mess"> <strong>Connexion</strong></p>
		<p id="indication">Connectez-vous pour accéder à votre palette de couleurs et vos anciens smileys.</p>

		<div id="formLogin">
			<form action="controleur.php" method="GET">
				<div class="log"><label for="login"> Adresse mail ou pseudo <span class="rouge">*</span></label> <br>
					<input type="text" id="login" name="login" placeholder="Adresse mail ou pseudo"
						value="<?php echo $login; ?>" />
				</div><br />
				<div class="log"><label for="passe">Mot de passe <span class="rouge">*</span></label><br>
					<input type="password" id="login" name="passe" placeholder="Mot de passe"
						value="<?php echo $passe; ?>" />
				</div><br />
				<div class="log"><span class="rouge">obligatoire*</span></div>
				<div id="bouton">
					<div id="coco">
						<input type="submit" name="action" value="Se connecter" id="compte" />
					</div>
					<div id="pascompte">
						Vous n'avez pas encore de compte ? <br /><a href="index.php?view=creer_compte">
							Inscrivez-vous</a>
					</div>
				</div>
				<!--si on a un message dans l'url, on l'affiche sur la page: -->
				<?php if (isset($_GET['msg'])) {
					// Récupérer la valeur du paramètre 'msg'
					$message = urldecode($_GET['msg']); // Décoder les caractères spéciaux dans le message
					echo '<div id="message">' . $message . '</div>';
				} ?>
			</form>
		</div>
</body>


<!-- **** F I N **** B O D Y **** -->

</html>