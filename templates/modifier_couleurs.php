<?php

session_start();
include_once("../libs/modele.php");
include_once("../libs/maLibForms.php");
include_once("../libs/maLibSecurisation.php");
include_once("../libs/maLibUtils.php");
include_once("../libs/maLibSQL.pdo.php");
//apres de nbs h de recherche, je ne comprenais pas pk le code ne 
//fonctionnait pas alors qu'il n'y avait pas d'rreurs ...
//aprs une analyses des trames dans "network", j'ai remarqué que la requete ajax marchait correctement puis j'ai decouvert
//dans la requete qui amene à ce fichier "preview" et j'ai trouvé des warmings et des err
//en effet, je n'avais pas le bon chemin d'accees pour les include_once
//j'ai donc regardé sur iternet.. et 'ai decouvert echo(__DIR__) et j'ai pu voir que le chemin d'acces n'etait pas le bon
//j'ai donc pu corriger le chemin d'acces et le code fonctionne correctement
//echo (__DIR__);

// Vérification de la présence des données envoyées par la requête AJAX
if (isset($_GET["colors"])) {
    // Récupération des couleurs envoyées depuis la requête AJAX
    // Récupération des couleurs envoyées depuis la requête AJAX
    $colorsString = $_GET["colors"];
    echo "Colors received: " . $colorsString;

    // Récupération de l'ID de l'utilisateur depuis la session
    $idUser = $_SESSION['idUser'];
    echo "User ID: " . $idUser;

    // Appel à une fonction pour mettre à jour les couleurs en base de données
    modifier_palette($idUser, $colorsString);


}



?>