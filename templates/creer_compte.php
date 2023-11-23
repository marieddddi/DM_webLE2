<?php

include_once("libs/modele.php");
include_once("libs/maLibForms.php");


// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
// Pas de soucis de bufferisation, puisque c'est dans le cas où on appelle directement la page sans son contexte
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
	header("Location:../index.php?view=login");
	die("");
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<!-- **** H E A D **** -->

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Smiley</title>
	<link rel="stylesheet" type="text/css" href="css/creercompte.css">
</head>
<!-- **** F I N **** H E A D **** -->


<!-- **** B O D Y **** -->

<body>
	<div id="corps">
		<div id="image">
			<img src="ressources/compte.jpg" />
		</div>
		<p id="mess"> <strong>Inscription</strong></p>
		<p id="indication">Inscrivez-vous pour personnaliser votre palette de couleurs et vos smileys.</p>


		<div id="formLogin">
			<form action="controleur.php" method="GET">
				<div id="coord">
					<div class="log"><label for="nom">Nom <span class="rouge">*</span></label><br>
						<input type="text" id="nomp" name="nom" placeholder="Nom" value="" />
					</div><br />
					<div class="log"><label for="prenom">Prénom <span class="rouge">*</span></label><br>
						<input type="text" id="nomp" name="prenom" placeholder="Prénom" value="" />
					</div><br />
				</div>
				<div class="log"><label for="login"> Adresse mail ou pseudo <span class="rouge">*</span></label> <br>
					<input type="text" id="login" name="login" placeholder="Adresse mail ou pseudo" value="" />
				</div><br />
				<div class="log"><label for="passe">Mot de passe <span class="rouge">*</span></label><br>
					<input type="password" id="login" name="passe" placeholder="Mot de passe" value="" />
				</div><br />
				<div class="log"><label for="passe2">Confirmer le mot de passe <span class="rouge">*</span></label><br>
					<input type="password" id="login" name="passe2" placeholder="Mot de passe" value="" />
				</div><br />
				<div class="log"><span class="rouge">obligatoire*</span></div>
				<div id="bouton">

					<div id="coco">
						<input type="submit" name="action" value="S inscrire" id="compte" />
					</div>
					<div id="dejacompte">
						Vous avez déjà un compte ? <br /><a href="index.php?view=login"> Connectez-vous</a>
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