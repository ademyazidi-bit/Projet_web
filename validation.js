function validerInscription() {
  var nom = document.getElementById('name').value;
  var email = document.getElementById('email').value;
  var motdepasse = document.getElementById('password').value;

  if (nom === '') {
    alert('Le nom est obligatoire');
    return false;
  }

  if (email === '') {
    alert('L email est obligatoire');
    return false;
  }

  if (motdepasse === '') {
    alert('Le mot de passe est obligatoire');
    return false;
  }

  if (motdepasse.length < 6) {
    alert('Le mot de passe doit avoir au moins 6 caractères');
    return false;
  }

  return true;
}

function validerConnexion() {
  var email = document.getElementById('email').value;
  var motdepasse = document.getElementById('password').value;

  if (email === '') {
    alert('L email est obligatoire');
    return false;
  }

  if (motdepasse === '') {
    alert('Le mot de passe est obligatoire');
    return false;
  }

  return true;
}