<?php
session_start();

include_once "libs/maLibUtils.php";
include_once "libs/maLibSQL.pdo.php";
include_once "libs/maLibSecurisation.php";
include_once "libs/modele.php";

$qs = $_GET;

if ($action = valider("action")) {
	ob_start();
	echo "Action = '$action' <br />";
	// ATTENTION : le codage des caractères peut poser PB si on utilise des actions comportant des accents... 
	// A EVITER si on ne maitrise pas ce type de problématiques


	switch ($action) {
		// Connexion //////////////////////////////////////////////////
		case 'Se connecter':
			$qs = array("view" => "accueil");
			// On verifie la presence des champs login et passe
			if (($login = valider("login")) && ($passe = valider("passe"))) {
				// On verifie l'utilisateur, 
				// et on crée des variables de session si tout est OK
				// Cf. maLibSecurisation
				if (verifUser($login, $passe)) {
					// tout s'est bien passé, doit-on se souvenir de la personne ? 
					if (valider("remember")) {
						setcookie("login", $login, time() + 60 * 60 * 24 * 30);
						setcookie("passe", $password, time() + 60 * 60 * 24 * 30);
						setcookie("remember", true, time() + 60 * 60 * 24 * 30);
					} else {
						setcookie("login", "", time() - 3600);
						setcookie("passe", "", time() - 3600);
						setcookie("remember", false, time() - 3600);
					}
				} else {
					$qs = array("msg" => " Pseudo ou mot de passe incorrect", "view" => "login");
					break;
				}
			} else {
				$qs = array("msg" => " Veuillez remplir tous les champs obligatoires", "view" => "login");
				break;
			}

			// On affiche deconnexion?>

			<?php
			break;

		case 'Logout':
			// traitement métier
			session_destroy();
			$qs = array("msg" => "Déconnexion réussie", "view" => "accueil");
			break;

		case "S inscrire":
			$nom = valider("nom");
			$prenom = valider("prenom");
			$pseudo = valider("login");
			$passe = valider("passe");
			$passe2 = valider("passe2");

			//verifier si les mots de passes correspondent 
			if ($passe != $passe2) {
				$qs = array("msg" => " Les mots de passe ne correspondent pas", "view" => "creer_compte");
				break;
			}
			//verifier si le format de l'email est valide
			if (veriflogin($pseudo)) {
				$qs = array("msg" => " Ce login est déjà utilisé", "view" => "creer_compte");
				break;
			}
			//verifier si l'utilisateur a bien entré un pseudo, mdp, nom et prénom
			if (empty($pseudo) || empty($passe) || empty($nom) || empty($prenom)) {
				$qs = array("msg" => " Veuillez compléter tous les champs obligatoires", "view" => "creer_compte");
				break;
			}
			//si tout est bon, on créait le compte 
			else {
				creer_compte($nom, $prenom, $pseudo, $passe);
				$qs = array("view" => "accueil");
				break;
			}



		case "Mon compte":
			$qs = array("view" => "mon_compte");
			break;

	}
}

// On redirige toujours vers la page index, mais on ne connait pas le répertoire de base
// On l'extrait donc du chemin du script courant : $_SERVER["PHP_SELF"]
// Par exemple, si $_SERVER["PHP_SELF"] vaut /chat/data.php, dirname($_SERVER["PHP_SELF"]) contient /chat

$urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";
// On redirige vers la page index avec les bons arguments

//header("Location:" . $urlBase . $qs);
rediriger($urlBase, $qs);

// On écrit seulement après cette entête
ob_end_flush();

?>