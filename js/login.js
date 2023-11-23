function affDeconnexion() {
  var val = document.getElementById("mess");
  if (val.innerHTML == "Se connecter") val.innerHTML = "se déconnecter";
  else val.innerHTML = "se connecter";
}
