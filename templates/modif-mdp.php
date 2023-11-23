<?php

// Si la page est appelée directement par son adresse, on redirige en passant par la page index
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
	<title>Les recettes du chef</title>
	<link rel="stylesheet" type="text/css" href="css/avis.css">
</head>
<!-- **** F I N **** H E A D **** -->


<!-- **** B O D Y **** -->

<body>
	<div id="Avis">
		<?php


		$sessionIdPers = $_SESSION['idUser'];

		echo "<h1>Modifier votre mot de passe ici !</h1>

		<div id='formPseudo'>
			<form action='controleur.php' method='GET'>
				<div class='log'><input type='hidden' id='idUser' name='idUser' value=" . $sessionIdPers . " required /></div><br />
				
				" ?>
		<div class="log">
			<p>Nouveau mot de passe: </p><input type="password" id="passe" name="passe" value="" required />
		</div><br />
		<div class="log">
			<p>Vérifier le nouveau mot de passe: </p><input type="password" id="passe2" name="passe2" value=""
				required />
		</div><br />

		<?php if (isset($_GET['msg']) && !empty($_GET['msg'])) {
			$message = $_GET['msg'];
			echo '<div id="msg">' . $message . '</div>';
		} ?>

		<input type="submit" name="action" value="Modifier le mot de passe" id="envoyer" />
		</form>
	</div>


	</div>



</body>
<!-- **** F I N **** B O D Y **** -->

</html>