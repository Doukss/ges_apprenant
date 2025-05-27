document.getElementById('btn-ajout-referentiel').addEventListener('click', function() {
  // Réinitialiser le formulaire et les messages d'erreur
  document.getElementById('referentielForm').reset();
  document.querySelectorAll('.label-text-alt').forEach(el => el.textContent = '');
  document.getElementById('modal-ajout-referentiel').showModal();
});

document.getElementById('referentielForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  // Réinitialiser les messages d'erreur
  document.querySelectorAll('.label-text-alt').forEach(el => el.textContent = '');
  
  let isValid = true;
  const libelle = document.getElementById('libelle');
  const description = document.getElementById('description');
  
  // Validation du libellé
  if (libelle.value.length < 3) {
    document.getElementById('libelle-error').textContent = 'Le libellé doit contenir au moins 3 caractères';
    isValid = false;
  }

  if (capacite.value.length < 1) {
    document.getElementById('capacite-error').textContent = 'Veuiller rensegner la capacité';
    isValid = false;
  }
  
  // Validation de la description
  if (description.value.length < 10) {
    document.getElementById('description-error').textContent = 'La description doit contenir au moins 10 caractères';
    isValid = false;
  }
  
  if (isValid) {
    this.submit();
  }
});
