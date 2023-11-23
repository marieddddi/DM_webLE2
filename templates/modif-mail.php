<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
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

		echo "<h1>Modifier votre mail ici !</h1>

		<div id='formMail'>
			<form action='controleur.php' method='GET'>
				<div class='log'><input type='hidden' id='idUser' name='idUser' value=" . $sessionIdPers . " required /></div><br />
				
				" ?>
		<div class="log">
			<p>Nouveau mail: </p><input type="text" id="mail" name="mail" value="" required />
		</div><br />
		<input type="submit" name="action" value="Modifier le mail" id="envoyer" />
		</form>
	</div>


	</div>



</body>
<!-- **** F I N **** B O D Y **** -->

</html>