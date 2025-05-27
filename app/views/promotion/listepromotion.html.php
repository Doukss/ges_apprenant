<?php
$view = $_GET['view'] ?? 'grille';
$currentPage = $pagination['current_page'];
$totalPages = $pagination['total_pages'];
?>

<div class="flex h-screen">
  <main class="flex-1">
    <div class="p-6 overflow-y-auto h-[80vh] -mt-5">
      <div class="p-6 bg-[#F9EFEF] rounded-xl">
        <!-- Page Titre -->
        <div class="flex justify-between items-center mb-2">
          <h1 class="text-2xl font-bold text-[#F9CF98]">Promotion</h1>
          <button id="btn-ajout-promotion" class="bg-[#F9CF98] text-[#87520E] px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-red-600 transition">
            <i class="ri-add-line"></i> Ajouter promotion
          </button>
        </div>
        <p class="text-sm text-gray-500 mb-4">Gérer les promotions de l'école</p>

        <!-- Statistique-->
        <div id="cardContainer" class="grid grid-cols-1 md:grid-cols-4 xl:grid-cols-4 gap-6">
          <div class="bg-red-700 text-[#F9CF98] p-4 rounded-lg text-center shadow">
            <p class="text-2xl font-bold">
              <?= isset($stats["total_apprenant"]) ? htmlspecialchars($stats["total_apprenant"]) : 0 ?>
            </p>
            <p>Apprenant</p>
          </div>
          <div class="bg-red-700 text-[#F9CF98] p-4 rounded-lg text-center shadow">
            <p class="text-2xl font-bold">
              <?= isset($stats["total_referentiel"]) ? htmlspecialchars($stats["total_referentiel"]) : 0 ?>
            </p>
            <p>Référentiel</p>
          </div>
          <div class="bg-red-700 text-[#F9CF98] p-4 rounded-lg text-center shadow">
            <p class="text-2xl font-bold">
              <?= isset($stats["total_promotionActive"]) ? htmlspecialchars($stats["total_promotionActive"]) : 0 ?>
            </p>
            <p>Promotion active</p>
          </div>
          <div class="bg-red-700 text-[#F9CF98] p-4 rounded-lg text-center shadow">
            <p class="text-2xl font-bold">
              <?= isset($stats["total_promotion"]) ? htmlspecialchars($stats["total_promotion"]) : 0 ?>
            </p>
            <p>Total promotion</p>
          </div>
        </div>

        <div class="flex justify-between items-center mb-4 mt-6">
          <form method="GET" action="" class="flex gap-2">
            <input type="hidden" name="controllers" value="promotion">
            <input type="hidden" name="page" value="listePromotion">
            <input type="hidden" name="view" value="<?= htmlspecialchars($view) ?>">
            <input type="text" name="search" placeholder="Rechercher une promotion..." 
                   value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" 
                   class="border px-2 py-1 rounded">
            <button type="submit" class="border border-gray-300 text-gray-400 px-4 py-1 rounded">
              <i class="ri-filter-3-line"></i>
            </button>
          </form>

          <div class="flex gap-2 items-center">
            <div>
              <select name="statusFilter" id="statusFilter" class="px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-400">
                <option value="all">Tous</option>
                <option value="active">Actif</option>
                <option value="inactive">Inactif</option>
              </select>
            </div>
            <a href="?controllers=promotion&page=listePromotion&view=grille<?= !empty($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '' ?>" 
               class="<?= $view === 'grille' ? 'text-[#F9CF98]' : 'text-gray-400' ?>" 
               aria-label="Vue grille">
              <i class="ri-layout-grid-2-fill text-2xl"></i>
            </a>
            <a href="?controllers=promotion&page=listePromotion&view=liste<?= !empty($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '' ?>" 
               class="<?= $view === 'liste' ? 'text-[#F9CF98]' : 'text-gray-400' ?>" 
               aria-label="Vue liste">
              <i class="ri-list-unordered text-2xl"></i>
            </a>
          </div>
        </div>

        <!-- Vue Grille -->
        <div class="<?= $view === 'grille' ? 'grid grid-cols-1 md:grid-cols-3 xl:grid-cols-3 gap-6' : 'hidden' ?>">
          <?php if (empty($promotions)): ?>
            <div class="col-span-full py-16 text-center animate-pulse">
              <div class="mx-auto w-28 h-28 rounded-full bg-gradient-to-br from-gray-100 to-gray-50 flex items-center justify-center mb-6 shadow-inner">
                <i class="fas fa-chalkboard-teacher text-4xl text-gray-300"></i>
              </div>
              <h3 class="text-xl font-medium text-gray-700">Aucune promotion programmée</h3>
              <p class="text-gray-400 mt-2">Les promotions apparaîtront ici</p>
            </div>
          <?php else: ?>
            <?php foreach ($promotions as $promotion): ?>
              <div class="relative bg-white rounded-2xl overflow-hidden shadow-lg border transition-all duration-500 group transform hover:-translate-y-2 border border-gray-100">
                <div class="p-5 pt-6">
                  <div class="flex justify-between items-start mb-4">
                    <div>
                      <h3 class="text-xl font-bold text-gray-700">
                        <?= htmlspecialchars($promotion["promotion"] ?? 'Non défini') ?>
                      </h3>
                      <div class="text-sm text-gray-500">
                        <span><?= htmlspecialchars($promotion["date_debut"] ?? 'Non assigné') ?></span>
                        <span> - </span>
                        <span><?= htmlspecialchars($promotion["date_fin"] ?? 'Non assigné') ?></span>
                      </div>
                    </div>
                    <div class="bg-gray-200 w-16 h-16 p-1 rounded-full">
                      <?php if (!empty($promotion['photo'])): ?>
                        <img src="data:image/jpeg;base64,<?= base64_encode($promotion['photo']) ?>" 
                             alt="Photo de la promotion" 
                             class="w-full h-full object-cover rounded-full">
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="mb-4">
                    <span class="inline-block px-3 py-1 rounded-full text-md font-medium text-gray-400">
                      <?= htmlspecialchars($promotion["nombre_apprenants"] ?? '0') ?> Apprenant(s)
                    </span>
                  </div>
                  <div class="mb-2">
                    <span class="text-sm text-gray-600">
                      <?= htmlspecialchars($promotion["referentiel"] ?? 'Non assigné') ?>
                    </span>
                  </div>
                  <div>
                    <span class="badge badge-soft badge-<?= colorState($promotion["statut"]) ?>">
                      <?= htmlspecialchars($promotion["statut"] ?? 'Non défini') ?>
                    </span>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <!-- Vue Liste -->
        <div id="tableContainer" class="<?= $view === 'liste' ? '' : 'hidden' ?> bg-white rounded-lg shadow overflow-hidden">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date_debut</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date_fin</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Référentiels</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <?php if (empty($promotions)): ?>
                <tr>
                  <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                    Aucune promotion trouvée
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($promotions as $promotion): ?>
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden">
                        <?php if (!empty($promotion['photo'])): ?>
                          <img src="data:image/jpeg;base64,<?= base64_encode($promotion['photo']) ?>" 
                               alt="Photo de la promotion" 
                               class="w-full h-full object-cover">
                        <?php endif; ?>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <?= htmlspecialchars($promotion["promotion"] ?? 'Non défini') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <?= htmlspecialchars($promotion["date_debut"] ?? 'Non assigné') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <?= htmlspecialchars($promotion["date_fin"] ?? 'Non assigné') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <?= htmlspecialchars($promotion["referentiel"] ?? 'Non assigné') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="badge badge-soft badge-<?= colorState($promotion["statut"]) ?>">
                        <?= htmlspecialchars($promotion["statut"] ?? 'Non défini') ?>
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <a href="?controllers=promotion&page=edit&id=<?= $promotion['id'] ?>" class="text-gray-600 hover:text-[#F9CF98] mr-3">
                        <i class="ri-edit-line"></i>
                      </a>
                      <a href="?controllers=promotion&action=delete&id=<?= $promotion['id'] ?>" 
                         class="text-gray-600 hover:text-[#F9CF98]" 
                         onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette promotion ?')">
                        <i class="ri-delete-bin-line"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
        <div class="flex justify-center mt-6">
          <div class="flex space-x-2">
            <?php if ($currentPage > 1): ?>
              <a href="?controllers=promotion&page=listePromotion&view=<?= $view ?>&page=<?= $currentPage - 1 ?><?= !empty($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '' ?>" 
                 class="px-3 py-1 border rounded hover:bg-gray-100">
                <i class="ri-arrow-left-s-line"></i>
              </a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
              <a href="?controllers=promotion&page=listePromotion&view=<?= $view ?>&page=<?= $i ?><?= !empty($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '' ?>" 
                 class="px-3 py-1 border rounded <?= $i === $currentPage ? 'bg-[#F9CF98] text-[#87520E]' : 'hover:bg-gray-100' ?>">
                <?= $i ?>
              </a>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
              <a href="?controllers=promotion&page=listePromotion&view=<?= $view ?>&page=<?= $currentPage + 1 ?><?= !empty($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '' ?>" 
                 class="px-3 py-1 border rounded hover:bg-gray-100">
                <i class="ri-arrow-right-s-line"></i>
              </a>
            <?php endif; ?>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </main>
</div>

<!-- Modal d'ajout de promotion -->
<dialog id="modal-ajout-promotion" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg mb-4">Ajouter une promotion</h3>
    
    <form action="?controllers=promotion&action=add" method="POST" class="space-y-4" id="promotionForm">
      <div class="form-control w-full">
        <label class="label">
          <span class="label-text">Nom de la promotion</span>
        </label>
        <input type="text" name="promotion" id="promotion"
          class="input input-bordered w-full " placeholder="promo" 
          minlength="3" maxlength="50">
        <label class="label">
          <span class="label-text-alt text-error" id="promotion-error"></span>
        </label>
      </div>

      <div class="form-control ">
        <label class="label">
          <span class="label-text">Images</span>
        </label>
        <input type="file" name="image" id="image"
          class="input input-bordered w-full " placeholder="">
        <label class="label">
          <span class="label-text-alt text-error" id="image-error"></span>
        </label>
      </div>

      <div class="form-control w-full">
        <label class="label">
          <span class="label-text">Référentiel</span>
        </label>
        <select name="referentiel" id="referentiel" 
          class="select select-bordered w-full">
          <option value="">Sélectionner un référentiel</option>
          <?php foreach ($referentiels as $ref): ?>
            <option value="<?= htmlspecialchars($ref['id']) ?>">
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
        <input type="date" name="date_debut" id="date_debut" 
          class="input input-bordered w-full">
        <label class="label">
          <span class="label-text-alt text-error" id="date_debut-error"></span>
        </label>
      </div>

      <div class="form-control w-full">
        <label class="label">
          <span class="label-text">Date de fin</span>
        </label>
        <input type="date" name="date_fin" id="date_fin" 
          class="input input-bordered w-full">
        <label class="label">
          <span class="label-text-alt text-error" id="date_fin-error"></span>
        </label>
      </div>

      <div class="modal-action">
        <button type="button" class="btn" onclick="document.getElementById('modal-ajout-promotion').close()">Annuler</button>
        <button type="submit" class="btn btn-primary bg-[#F9CF98] w-24">Enregistrer</button>
      </div>
    </form>
  </div>
</dialog>

<script>
document.getElementById('btn-ajout-promotion').addEventListener('click', function() {
  document.getElementById('promotionForm').reset();
  document.querySelectorAll('.label-text-alt').forEach(el => el.textContent = '');
  document.getElementById('modal-ajout-promotion').showModal();
});

document.getElementById('promotionForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  document.querySelectorAll('.label-text-alt').forEach(el => el.textContent = '');
  
  let isValid = true;
  const promotion = document.getElementById('promotion');
  const referentiel = document.getElementById('referentiel');
  const dateDebut = document.getElementById('date_debut');
  const dateFin = document.getElementById('date_fin');
  
  if (promotion.value.length < 3) {
    document.getElementById('promotion-error').textContent = 'Le nom est requis';
    isValid = false;
  }
  
  if (!referentiel.value) {
    document.getElementById('referentiel-error').textContent = 'Veuillez sélectionner un référentiel';
    isValid = false;
  }
  
  if (!dateDebut.value) {
    document.getElementById('date_debut-error').textContent = 'Veuillez sélectionner une date de début';
    isValid = false;
  }

  if (!image.value) {
    document.getElementById('image-error').textContent = 'Veuillez sélectionner une image';
    isValid = false;
  }
  
  if (!dateFin.value) {
    document.getElementById('date_fin-error').textContent = 'Veuillez sélectionner une date de fin';
    isValid = false;
  }
  
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