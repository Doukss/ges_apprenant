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
        <!-- <div id="cardContainer" class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-3 gap-6 mb-6 <?= $view === 'liste' ? 'hidden' : '' ?>">
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
        </div> -->

        <div class="flex justify-between items-center mb-6">
          <form method="GET" action="" class="flex items-center gap-4">
            <input type="hidden" name="controller" value="referentiel">
            <input type="hidden" name="page" value="listeReferentiel">
            <input type="hidden" name="view" value="<?= htmlspecialchars($view) ?>">
            
            <input type="text" name="search" placeholder="Rechercher un référentiel..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" class="border px-2 py-1 rounded">
            
            <button type="submit" class="border border-gray-300 text-gray-400 px-4 py-1 rounded">Rechercher</button>

          </form>        
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
                <!-- Image du référentiel -->
                <div class="h-40 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center overflow-hidden">
                   <img src="assets/images/milkos.jpg" alt="<?= htmlspecialchars($referentiel["libelle"] ?? 'Référentiel') ?>" 
                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                        onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiB2aWV3Qm94PSIwIDAgMjQgMjQiIGZpbGw9Im5vbmUiIHN0cm9rZT0iI2ZmZiIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiPjxyZWN0IHg9IjMiIHk9IjMiIHdpZHRoPSIxOCIgaGVpZ2h0PSIxOCIgcng9IjIiIHJ5PSIyIj48L3JlY3Q+PGNpcmNsZSBjeD0iOC41IiBjeT0iOC41IiByPSIxLjUiPjwvY2lyY2xlPjxwb2x5bGluZSBwb2ludHM9IjIxIDE1IDEzIDEwIDUgMjEgNSAzIj48L3BvbHlsaW5lPjwvc3ZnPg=='">
                </div>
                
                <div class="p-5 pt-6">
                  <div class="flex justify-between items-start mb-4">
                    <div>
                      <h3 class="text-xl font-bold text-gray-700">
                        <?= htmlspecialchars($referentiel["libelle"] ?? 'Non défini') ?>
                      </h3>
                      <p class="text-sm text-gray-500 mt-1 line-clamp-2">
                        <?= htmlspecialchars($referentiel["description"] ?? 'Aucune description') ?>
                      </p>
                    </div>
                  </div>
                  
                  <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                      <i class="ri-user-line text-gray-400"></i>
                      <span class="text-sm text-gray-500">
                        Capacité: <?= htmlspecialchars($referentiel["capacite"] ?? '50') ?> places
                      </span>
                    </div>
                    
                    <!-- Actions au survol -->
                    <!-- <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex gap-2">
                      <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-full transition-colors" title="Modifier">
                        <i class="ri-pencil-line"></i>
                      </button>
                      <button class="p-2 text-red-600 hover:bg-red-50 rounded-full transition-colors" title="Supprimer">
                        <i class="ri-delete-bin-line"></i>
                      </button>
                    </div> -->
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

       
      </div>
    </div>
  </main>
</div>

<script>
  // Confirmation avant suppression
  document.querySelectorAll('.ri-delete-bin-line').forEach(icon => {
    icon.closest('button').addEventListener('click', function(e) {
      if(!confirm('Êtes-vous sûr de vouloir supprimer ce référentiel ?')) {
        e.preventDefault();
      }
    });
  });
</script>

<!-- Pagination -->
<div class="flex justify-center mt-6 mb-6">
  <div class="flex space-x-2">
    <?php if ($total_pages > 1): ?>
      <?php if ($current_page > 1): ?>
        <a href="?controller=referentiel&page=listeReferentiel&view=<?= $view ?>&page_num=<?= $current_page - 1 ?>&per_page=<?= $items_per_page ?><?= isset($_GET['search']) ? '&search=' . htmlspecialchars($_GET['search']) : '' ?>" 
           class="px-4 py-2 bg-[#F9CF98] text-white rounded hover:bg-red-600 transition">
          Précédent
        </a>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?controller=referentiel&page=listeReferentiel&view=<?= $view ?>&page_num=<?= $i ?>&per_page=<?= $items_per_page ?><?= isset($_GET['search']) ? '&search=' . htmlspecialchars($_GET['search']) : '' ?>" 
           class="px-4 py-2 <?= $i === $current_page ? 'bg-red-600 text-white' : 'bg-[#F9CF98] text-white' ?> rounded hover:bg-red-600 transition">
          <?= $i ?>
        </a>
      <?php endfor; ?>

      <?php if ($current_page < $total_pages): ?>
        <a href="?controller=referentiel&page=listeReferentiel&view=<?= $view ?>&page_num=<?= $current_page + 1 ?>&per_page=<?= $items_per_page ?><?= isset($_GET['search']) ? '&search=' . htmlspecialchars($_GET['search']) : '' ?>" 
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
    
    <form action="?controller=referentiel&action=add" method="POST" class="space-y-4" id="referentielForm">
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
          <span class="label-text">Capacité</span>
        </label>
        <input type="number" name="capacite" id="capacite"
          class="input input-bordered w-full" placeholder="La capacite" 
          minlength="3" maxlength="50">
        <label class="label">
          <span class="label-text-alt text-error" id="capacite-error"></span>
        </label>
      </div>

       <div class="form-control w-full">
        <label class="label">
          <span class="label-text">Image</span>
        </label>
        <input type="file" name="capacite" id="img"
          class="input input-bordered w-full" 
          minlength="3" maxlength="50">
        <label class="label">
          <span class="label-text-alt text-error" id="img-error"></span>
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
        <button type="submit" class="btn btn-primary bg-red-400">Enregistrer</button>
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

  if (capacite.value.length < 1) {
    document.getElementById('capacite-error').textContent = 'Veuiller rensegner la capacité';
    isValid = false;
  }

  if (img.value.length < 1) {
    document.getElementById('img-error').textContent = 'Veuiller enregistrer une image';
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
