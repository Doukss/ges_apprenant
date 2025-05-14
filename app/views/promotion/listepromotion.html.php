<?php
$view = $_GET['view'] ?? 'grille'; // valeur par défaut : grille
?>


<div class="flex h-screen ">
  <main class="flex-1 ">
    <div class="p-6 overflow-y-auto h-[80vh] -mt-5">
      <div class="p-6 bg-[#F9EFEF] rounded-xl">
        <!-- Page Titre -->
        <div class="flex justify-between items-center mb-2">
          <h1 class="text-2xl font-bold text-[#F9CF98]">Promotion</h1>
          <button class="bg-[#F9CF98] text-[#87520E] px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-red-600 transition">
            <i class="ri-add-line"></i> Ajouter promotion
          </button>
        </div>
        <p class="text-sm text-gray-500 mb-4">Gérer les promotions de l'école</p>

        <!-- Statistique-->
<div id="cardContainer" class="grid grid-cols-1 md:grid-cols-4 xl:grid-cols-4 gap-6 <?= $view === 'liste' ?'hidden' : '' ?>">
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

        <div class="flex justify-between items-center mb-4">
        <form method="GET" action="">
         <input type="hidden" name="controllers" value="promotion">
         <input type="hidden" name="page" value="listePromotion">
    
         <input type="text" name="search" placeholder="Rechercher une promotion..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" class="border px-2 py-1 rounded">
    
         <button type="submit" class="border border-gray-300 text-gray-400  px-4 py-1 rounded">Rechercher</button>
        </form>

          <div class="flex gap-2 p-6">
            <div>
              <select name="statusFilter" id="statusFilter" class="px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-400">
                <option value="all">Tous</option>
                <option value="active">Actif</option>
                <option value="inactive">Inactif</option>
              </select>
            </div>
          <a href="?controllers=promotion&page=grille" class="bg-[#F9CF98] text-white p-2 rounded hover:bg-red-600 transition" aria-label="Vue grille">
          Grille
          </a>
          <a href="?controllers=promotion&page=liste" class="bg-gray-200 hover:bg-red-600 p-2 rounded transition" aria-label="Vue liste">
          Liste
          </a>

          </div>
          
        </div>

        <div class="<?= $view === 'grille' ? 'grid grid-cols-1 md:grid-cols-3 xl:grid-cols-3 gap-6' : 'hidden' ?>">
          <?php if (empty($promotions)): ?>
            
            <div class="col-span-full py-16 text-center animate-pulse">
              <div class="mx-auto w-28 h-28 rounded-full bg-gradient-to-br from-gray-100 to-gray-50 flex items-center justify-center mb-6 shadow-inner">
                <i class="fas fa-chalkboard-teacher text-4xl text-gray-300"></i>
              </div>
              <h3 class="text-xl font-medium text-gray-700">Aucun promotions programmé</h3>
              <p class="text-gray-400 mt-2">Les promotions apparaîtront ici</p>
            </div>
          <?php else: ?>
            <?php foreach ($promotions as $promotion): ?>
              <div class="relative bg-white rounded-2xl overflow-hidden shadow-lg border transition-all duration-500 group transform hover:-translate-y-2 border border-gray-100 ">

                <!-- Contenu principal -->
                <div class="p-5 pt-6">
                  <!-- En-tête -->
                  <div class="flex justify-between items-start mb-4">
                    <div>
                      <h3 class="text-xl font-bold text-gray-700">
                        <?= htmlspecialchars($promotion["promotion"] ?? 'Non défini') ?>
                      </h3>

                      <div class="">
                        <span class=" text-xs font-medium text-gray-500">
                          <?= htmlspecialchars($promotion["date_debut"] ?? 'Non assigné') ?>
                        </span>
                        <span class=" text-xs font-medium text-gray-500">
                          <?= htmlspecialchars($promotion["date_fin"] ?? 'Non assigné') ?>
                        </span>
                       
                      </div>

                    </div>
                    <div class="bg-gray-200 w-[10%] h-[10%] p-5 rounded-full">
                    </div>

                 
                  </div>

                  <div class="mb-4">
                  <span class="inline-block px-3 py-1 rounded-full text-md font-medium  text-gray-400">
                      <?= htmlspecialchars($promotion["nombre_apprenants"] ?? 'Non assigné') ?> Apprenant
                    </span>
                  </div>
                      <?= htmlspecialchars($promotion["referentiel"] ?? 'Non assigné') ?>
                  <div >
                  <p class="text-sm text-red-900">
                     <span class="badge badge-soft badge-<?= colorState($promotion["statut"]) ?>"><?= htmlspecialchars($promotion["statut"] ?? 'Non défini') ?></span> 
                    </p>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <div id="tableContainer" class="<?= $view === 'liste' ? '' : 'hidden' ?> bg-white rounded-lg shadow  overflow-hidden">
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
            <tbody id="tableBody" class="bg-white divide-y divide-gray-200">

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

</div>