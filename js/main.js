function rgbToHex(rgbString) {
  var rgbArray = rgbString.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
  if (!rgbArray) return rgbString;

  function hex(x) {
    return ("0" + parseInt(x).toString(16)).slice(-2);
  }

  return "#" + hex(rgbArray[1]) + hex(rgbArray[2]) + hex(rgbArray[3]);
}

//////////////////////////////////////////////////////////////////////////////////////////

// Fonction pour afficher la fenêtre pop-up
function showPopup() {
  document.getElementById("popup-overlay").classList.add("show");
}

// Fonction pour masquer la fenêtre pop-up
function hidePopup() {
  document.getElementById("popup-overlay").classList.remove("show");
}


//////////////////////////////////////////////////////////////////////////////////////////

function affDeconnexion() {
  var val = document.getElementById("mess");
  if (val.innerHTML == "Se connecter") val.innerHTML = "se déconnecter";
  else val.innerHTML = "se connecter";
}






//////////////////////////////////////////////////////////////////////////////////////////

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
function conversion_chaine($couleurs) {
  // Explode la chaîne de couleurs en un tableau en utilisant la virgule comme séparateur
  $couleursArray = explode(',', $couleurs);

  // Nettoie le tableau des éventuels espaces vides ou valeurs vides
  $couleursArray = array_filter(array_map('trim', $couleursArray));

  // Retourne le tableau des couleurs
  return $couleursArray;
}


function transforme() {
  var chaine = obtenirChaineCouleurs();
  $.ajax({
    url: "templates/modifier_couleurs.php",
    type: "GET",
    data: {
      chaine: chaine
    },
    success: function (data) {
      console.log(data);
    }
  });
  console.log(chaine);
}

function enregistrePNG(taille) {
  convertToImageAndDownload(obtenirChaineCouleurs(), taille);
}


function convertToImageAndDownload(chaineCouleurs, taille) {
  var largeur = Math.sqrt(chaineCouleurs.split(',').length - 1); // Obtenez la largeur de l'image depuis la chaîne
  var canvas = document.createElement('canvas');
  var tailleCanvas = 500;

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