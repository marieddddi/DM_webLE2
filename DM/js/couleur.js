function rgbToHex(rgbString) {
  var rgbArray = rgbString.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
  if (!rgbArray) return rgbString;

  function hex(x) {
    return ("0" + parseInt(x).toString(16)).slice(-2);
  }

  return "#" + hex(rgbArray[1]) + hex(rgbArray[2]) + hex(rgbArray[3]);
}

// Exemple d'utilisation de la fonction
var rgbColorString = "rgb(255, 0, 255)";
var hexColorString = rgbToHex(rgbColorString);
console.log(hexColorString); // Affiche la couleur en format hexadécimal

$(document).ready(function () {
  var couleurModifiable = false;
  var color;
  var selectedColors = [];
  $(".color").each(function () {
    selectedColors.push($(this).css("background-color"));
  });
  console.log(selectedColors);
  // Cacher la liste des choix de couleurs au chargement de la page
  $("#choix_couleurs").hide();
  $("#validercouleur").hide();

  // Gestion du clic sur le bouton "Modifier"
  $("#changercouleur").click(function () {
    console.log("modif");
    // Afficher ou masquer la liste des choix de couleurs
    couleurModifiable = true;
    $("#choix_couleurs").show();
    $("#changercouleur").hide();
    $("#validercouleur").show();
  });

  // Gestion du clic sur le bouton "Valider"
  $("#validercouleur").click(function () {
    console.log("valider");
    // Afficher ou masquer la liste des choix de couleurs
    $("#choix_couleurs").hide();
    $("#validercouleur").hide();
    $("#changercouleur").show();
    couleurModifiable = false;
    var hexColors = selectedColors.map(function (color) {
      return rgbToHex(color);
    });

    var colorsString = hexColors.join(",");

    $.ajax({
      type: "GET",
      url: "templates/modifier_couleurs.php", // URL du script PHP pour la mise à jour en base de données
      data: { colors: colorsString }, // Envoyer les couleurs sous forme de paramètre
      success: function (response) {
        console.log("Couleurs mises à jour en base de données !");
        console.log(colorsString);
        // Gérer la réponse du serveur si nécessaire
      },
    });
  });

  // Gestion du clic sur une couleur de la liste de choix

  $(".color").click(function () {
    if (couleurModifiable === true) {
      $(".coulcoul").click(function () {
        color = $(this).css("background-color"); // Récupérer la couleur de fond de l'élément cliqué
      });
      $(this).css("background-color", color);
      var index = $(".color").index(this);
      selectedColors[index] = color;
      console.log(selectedColors);
    }
  });
});
