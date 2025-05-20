<!-- Bouton pour ouvrir le modal -->
<button class="btn btn-primary" onclick="document.getElementById('modal-ajout-promotion').showModal()">Ajouter une promotion</button>

<!-- Modal -->
<dialog id="modal-ajout-promotion" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg mb-4">Ajouter une promotion</h3>
    
    <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
      <div class="alert alert-error mb-4">
        <ul class="list-disc list-inside">
          <?php foreach ($_SESSION['errors'] as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form action="?controllers=promotion&action=add" method="POST" enctype="multipart/form-data" class="space-y-4" id="promotionForm">
      <div class="form-control w-full">
        <label class="label">
          <span class="label-text">Nom de la promotion</span>
        </label>
        <input type="text" name="promotion" id="promotion" required
          value="<?= htmlspecialchars($_SESSION['form_data']['promotion'] ?? '') ?>"
          class="input input-bordered w-full <?= isset($_SESSION['errors']['promotion']) ? 'input-error' : '' ?>"
          minlength="3" maxlength="50">
        <label class="label">
          <span class="label-text-alt text-error" id="promotion-error"></span>
        </label>
      </div>

      <div class="form-control w-full">
        <label class="label">
          <span class="label-text">Référentiel</span>
        </label>
        <select name="referentiel" id="referentiel" required
          class="select select-bordered w-full <?= isset($_SESSION['errors']['referentiel']) ? 'select-error' : '' ?>">
          <option value="">Sélectionner un référentiel</option>
          <?php foreach ($referentiels as $ref): ?>
            <option value="<?= htmlspecialchars($ref['id']) ?>" 
              <?= (isset($_SESSION['form_data']['referentiel']) && $_SESSION['form_data']['referentiel'] == $ref['id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($ref['libelle']) ?>
            </option>
          <?php endforeach; ?>
        </select>
        <label class="label">
          <span class="label-text-alt text-error" id="referentiel-error"></span>
        </label>
      </div>

      <div class="form-control w-full">
        <label class="label">
          <span class="label-text">Date de début</span>
        </label>
        <input type="date" name="date_debut" id="date_debut" required
          value="<?= htmlspecialchars($_SESSION['form_data']['date_debut'] ?? '') ?>"
          class="input input-bordered w-full <?= isset($_SESSION['errors']['date_debut']) ? 'input-error' : '' ?>">
        <label class="label">
          <span class="label-text-alt text-error" id="date_debut-error"></span>
        </label>
      </div>

      <div class="form-control w-full">
        <label class="label">
          <span class="label-text">Date de fin</span>
        </label>
        <input type="date" name="date_fin" id="date_fin" required
          value="<?= htmlspecialchars($_SESSION['form_data']['date_fin'] ?? '') ?>"
          class="input input-bordered w-full <?= isset($_SESSION['errors']['date_fin']) ? 'input-error' : '' ?>">
        <label class="label">
          <span class="label-text-alt text-error" id="date_fin-error"></span>
        </label>
      </div>

      <div class="form-control w-full">
        <label class="label">
          <span class="label-text">Photo de la promotion</span>
        </label>
        <input type="file" name="photo" id="photo" accept="image/*" required
          class="file-input file-input-bordered w-full <?= isset($_SESSION['errors']['photo']) ? 'file-input-error' : '' ?>">
        <label class="label">
          <span class="label-text-alt text-error" id="photo-error"></span>
        </label>
      </div>

      <div class="modal-action">
        <button type="button" class="btn" onclick="document.getElementById('modal-ajout-promotion').close()">Annuler</button>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
      </div>
    </form>
  </div>
</dialog>

<script>
document.getElementById('promotionForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  // Réinitialiser les messages d'erreur
  document.querySelectorAll('.label-text-alt').forEach(el => el.textContent = '');
  
  let isValid = true;
  const promotion = document.getElementById('promotion');
  const referentiel = document.getElementById('referentiel');
  const dateDebut = document.getElementById('date_debut');
  const dateFin = document.getElementById('date_fin');
  
  // Validation du nom de la promotion
  if (promotion.value.length < 3) {
    document.getElementById('promotion-error').textContent = 'Le nom doit contenir au moins 3 caractères';
    isValid = false;
  }
  
  // Validation du référentiel
  if (!referentiel.value) {
    document.getElementById('referentiel-error').textContent = 'Veuillez sélectionner un référentiel';
    isValid = false;
  }
  
  // Validation des dates
  if (!dateDebut.value) {
    document.getElementById('date_debut-error').textContent = 'Veuillez sélectionner une date de début';
    isValid = false;
  }
  
  if (!dateFin.value) {
    document.getElementById('date_fin-error').textContent = 'Veuillez sélectionner une date de fin';
    isValid = false;
  }
  
  // Vérifier que la date de fin est après la date de début
  if (dateDebut.value && dateFin.value && new Date(dateFin.value) <= new Date(dateDebut.value)) {
    document.getElementById('date_fin-error').textContent = 'La date de fin doit être postérieure à la date de début';
    isValid = false;
  }
  
  if (isValid) {
    this.submit();
  }
});
</script>

<?php
// Nettoyer les données de session après l'affichage
unset($_SESSION['errors']);
unset($_SESSION['form_data']);
?> 