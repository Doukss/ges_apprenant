<?php
$view = $_GET['view'] ?? 'grille'; // valeur par défaut : grille
$items_per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 6;
$current_page = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
$total_items = count($referentiels);
$total_pages = ceil($total_items / $items_per_page);
$offset = ($current_page - 1) * $items_per_page;
$referentiels_page = array_slice($referentiels, $offset, $items_per_page);
?>

<div class="flex h-screen">
  <main class="flex-1">
    <div class="p-6 overflow-y-auto h-[80vh] -mt-5">
      <div class="p-6 bg-[#F9EFEF] rounded-xl">
        <!-- Page Titre -->
        <div class="flex justify-between items-center mb-2">
          <h1 class="text-2xl font-bold text-[#F9CF98]">Référentiels</h1>
          <button id="btn-ajout-referentiel" class="bg-[#F9CF98] text-[#87520E] px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-red-600 transition">
            <i class="ri-add-line"></i> Ajouter référentiel
          </button>
        </div>
        <p class="text-sm text-gray-500 mb-4">Gérer les référentiels de l'école</p>

        <!-- Statistique -->
        <div id="cardContainer" class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-3 gap-6 <?= $view === 'liste' ? 'hidden' : '' ?>">
          <div class="bg-red-700 text-[#F9CF98] p-4 rounded-lg text-center shadow">
            <p class="text-2xl font-bold">
              <?= isset($stats["total_referentiel"]) ? htmlspecialchars($stats["total_referentiel"]) : 0 ?>
            </p>
            <p>Total Référentiels</p>
          </div>
          <div class="bg-red-700 text-[#F9CF98] p-4 rounded-lg text-center shadow">
            <p class="text-2xl font-bold">
              <?= isset($stats["referentiel_actif"]) ? htmlspecialchars($stats["referentiel_actif"]) : 0 ?>
            </p>
            <p>Référentiels Actifs</p>
          </div>
          <div class="bg-red-700 text-[#F9CF98] p-4 rounded-lg text-center shadow">
            <p class="text-2xl font-bold">
              <?= isset($stats["referentiel_inactif"]) ? htmlspecialchars($stats["referentiel_inactif"]) : 0 ?>
            </p>
            <p>Référentiels Inactifs</p>
          </div>
        </div>

        <div class="flex justify-between items-center mb-4">
          <form method="GET" action="" class="flex items-center gap-4">
            <input type="hidden" name="controllers" value="referentiel">
            <input type="hidden" name="page" value="listeReferentiel">
            <input type="hidden" name="view" value="<?= htmlspecialchars($view) ?>">
            
            <input type="text" name="search" placeholder="Rechercher un référentiel..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" class="border px-2 py-1 rounded">
            
            <button type="submit" class="border border-gray-300 text-gray-400 px-4 py-1 rounded">Rechercher</button>

            <select name="per_page" onchange="this.form.submit()" class="border px-2 py-1 rounded">
              <option value="6" <?= $items_per_page == 6 ? 'selected' : '' ?>>6 par page</option>
              <option value="12" <?= $items_per_page == 12 ? 'selected' : '' ?>>12 par page</option>
              <option value="24" <?= $items_per_page == 24 ? 'selected' : '' ?>>24 par page</option>
              <option value="48" <?= $items_per_page == 48 ? 'selected' : '' ?>>48 par page</option>
            </select>
          </form>

          <div class="flex gap-2 p-6">
            <div>
              <select name="statusFilter" id="statusFilter" class="px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-400">
                <option value="all">Tous</option>
                <option value="active">Actif</option>
                <option value="inactive">Inactif</option>
              </select>
            </div>
            <a href="?controllers=referentiel&page=listeReferentiel&view=grille" class="<?= $view === 'grille' ? 'bg-[#F9CF98] text-white' : 'bg-gray-200' ?> p-2 rounded hover:bg-red-600 transition" aria-label="Vue grille">
              Grille
            </a>
            <a href="?controllers=referentiel&page=listeReferentiel&view=liste" class="<?= $view === 'liste' ? 'bg-[#F9CF98] text-white' : 'bg-gray-200' ?> p-2 rounded hover:bg-red-600 transition" aria-label="Vue liste">
              Liste
            </a>
          </div>
        </div>

        <!-- Vue Grille -->
        <div class="<?= $view === 'grille' ? 'grid grid-cols-1 md:grid-cols-3 xl:grid-cols-3 gap-6' : 'hidden' ?>">
          <?php if (empty($referentiels_page)): ?>
            <div class="col-span-full py-16 text-center animate-pulse">
              <div class="mx-auto w-28 h-28 rounded-full bg-gradient-to-br from-gray-100 to-gray-50 flex items-center justify-center mb-6 shadow-inner">
                <i class="fas fa-book text-4xl text-gray-300"></i>
              </div>
              <h3 class="text-xl font-medium text-gray-700">Aucun référentiel trouvé</h3>
              <p class="text-gray-400 mt-2">Les référentiels apparaîtront ici</p>
            </div>
          <?php else: ?>
            <?php foreach ($referentiels_page as $referentiel): ?>
              <div class="relative bg-white rounded-2xl overflow-hidden shadow-lg border transition-all duration-500 group transform hover:-translate-y-2 border border-gray-100">
                <div class="p-5 pt-6">
                  <div class="flex justify-between items-start mb-4">
                    <div>
                      <h3 class="text-xl font-bold text-gray-700">
                        <?= htmlspecialchars($referentiel["libelle"] ?? 'Non défini') ?>
                      </h3>
                      <p class="text-sm text-gray-500 mt-1">
                        <?= htmlspecialchars($referentiel["description"] ?? 'Aucune description') ?>
                      </p>
                    </div>
                  </div>
                  <div class="mb-4">
                    <span class="inline-block px-3 py-1 rounded-full text-md font-medium text-gray-400">
                      <?= htmlspecialchars($referentiel["nombre_promotions"] ?? '0') ?> Promotions
                    </span>
                  </div>
                  <div>
                    <p class="text-sm text-red-900">
                      <span class="badge badge-soft badge-<?= colorState($referentiel["statut"]) ?>">
                        <?= htmlspecialchars($referentiel["statut"] ?? 'Non défini') ?>
                      </span>
                    </p>
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
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Libellé</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre de Promotions</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
              </tr>
            </thead>
            <tbody id="tableBody" class="bg-white divide-y divide-gray-200">
              <?php foreach ($referentiels_page as $referentiel): ?>
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <?= htmlspecialchars($referentiel["libelle"] ?? 'Non défini') ?>
                  </td>
                  <td class="px-6 py-4">
                    <?= htmlspecialchars($referentiel["description"] ?? 'Aucune description') ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <?= htmlspecialchars($referentiel["nombre_promotions"] ?? '0') ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="badge badge-soft badge-<?= colorState($referentiel["statut"]) ?>">
                      <?= htmlspecialchars($referentiel["statut"] ?? 'Non défini') ?>
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
</div>

<!-- Pagination -->
<div class="flex justify-center mt-6 mb-6">
  <div class="flex space-x-2">
    <?php if ($total_pages > 1): ?>
      <?php if ($current_page > 1): ?>
        <a href="?controllers=referentiel&page=listeReferentiel&view=<?= $view ?>&page_num=<?= $current_page - 1 ?>&per_page=<?= $items_per_page ?><?= isset($_GET['search']) ? '&search=' . htmlspecialchars($_GET['search']) : '' ?>" 
           class="px-4 py-2 bg-[#F9CF98] text-white rounded hover:bg-red-600 transition">
          Précédent
        </a>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?controllers=referentiel&page=listeReferentiel&view=<?= $view ?>&page_num=<?= $i ?>&per_page=<?= $items_per_page ?><?= isset($_GET['search']) ? '&search=' . htmlspecialchars($_GET['search']) : '' ?>" 
           class="px-4 py-2 <?= $i === $current_page ? 'bg-red-600 text-white' : 'bg-[#F9CF98] text-white' ?> rounded hover:bg-red-600 transition">
          <?= $i ?>
        </a>
      <?php endfor; ?>

      <?php if ($current_page < $total_pages): ?>
        <a href="?controllers=referentiel&page=listeReferentiel&view=<?= $view ?>&page_num=<?= $current_page + 1 ?>&per_page=<?= $items_per_page ?><?= isset($_GET['search']) ? '&search=' . htmlspecialchars($_GET['search']) : '' ?>" 
           class="px-4 py-2 bg-[#F9CF98] text-white rounded hover:bg-red-600 transition">
          Suivant
        </a>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</div>

<!-- Modal d'ajout de référentiel -->
<dialog id="modal-ajout-referentiel" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg mb-4">Ajouter un référentiel</h3>
    
    <form action="?controllers=referentiel&action=add" method="POST" class="space-y-4" id="referentielForm">
      <div class="form-control w-full">
        <label class="label">
          <span class="label-text">Libellé</span>
        </label>
        <input type="text" name="libelle" id="libelle"
          class="input input-bordered w-full" placeholder="Libellé du référentiel" 
          minlength="3" maxlength="50">
        <label class="label">
          <span class="label-text-alt text-error" id="libelle-error"></span>
        </label>
      </div>

      <div class="form-control w-full">
        <label class="label">
          <span class="label-text">Description</span>
        </label>
        <textarea name="description" id="description" 
          class="textarea textarea-bordered w-full" 
          placeholder="Description du référentiel"
          rows="3"></textarea>
        <label class="label">
          <span class="label-text-alt text-error" id="description-error"></span>
        </label>
      </div>

      <div class="modal-action">
        <button type="button" class="btn" onclick="document.getElementById('modal-ajout-referentiel').close()">Annuler</button>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
      </div>
    </form>
  </div>
</dialog>

<script>
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
  
  // Validation de la description
  if (description.value.length < 10) {
    document.getElementById('description-error').textContent = 'La description doit contenir au moins 10 caractères';
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
