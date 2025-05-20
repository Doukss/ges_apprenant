<div class="flex h-screen">
  <main class="flex-1">
    <div class="p-6 overflow-y-auto">
      <div class="max-w-3xl mx-auto bg-[#F9EFEF] rounded-xl p-6">
        <div class="mb-6 flex justify-between items-center">
          <div>
            <h1 class="text-2xl font-bold text-[#F9CF98]"><?= htmlspecialchars($promotion['promotion']) ?></h1>
            <p class="text-sm text-gray-500">Détails de la promotion</p>
          </div>
          <div class="flex space-x-4">
            <a href="?controllers=promotion&page=modifierPromotion&id=<?= htmlspecialchars($promotion['id']) ?>" 
              class="px-4 py-2 bg-[#F9CF98] text-[#87520E] rounded-md hover:bg-[#87520E] hover:text-[#F9CF98] transition flex items-center gap-2">
              <i class="ri-edit-line"></i> Modifier
            </a>
            <button onclick="confirmerSuppression(<?= htmlspecialchars($promotion['id']) ?>)"
              class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition flex items-center gap-2">
              <i class="ri-delete-bin-line"></i> Supprimer
            </button>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 space-y-6">
          <!-- Informations générales -->
          <div class="grid grid-cols-2 gap-6">
            <div>
              <h3 class="text-sm font-medium text-gray-500">Référentiel</h3>
              <p class="mt-1 text-lg text-gray-900"><?= htmlspecialchars($promotion['referentiel']) ?></p>
            </div>
            <div>
              <h3 class="text-sm font-medium text-gray-500">Statut</h3>
              <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                <?= $promotion['statut'] == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                <?= htmlspecialchars($promotion['statut']) ?>
              </span>
            </div>
            <div>
              <h3 class="text-sm font-medium text-gray-500">Date de début</h3>
              <p class="mt-1 text-lg text-gray-900"><?= htmlspecialchars($promotion['date_debut']) ?></p>
            </div>
            <div>
              <h3 class="text-sm font-medium text-gray-500">Date de fin</h3>
              <p class="mt-1 text-lg text-gray-900"><?= htmlspecialchars($promotion['date_fin']) ?></p>
            </div>
          </div>

          <!-- Liste des apprenants -->
          <div class="mt-8">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Liste des apprenants</h2>
            <?php if (!empty($promotion['apprenants'])): ?>
              <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-gray-200">
                  <?php foreach ($promotion['apprenants'] as $apprenant): ?>
                    <li class="px-6 py-4 flex items-center justify-between">
                      <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                          <img class="h-10 w-10 rounded-full" src="<?= htmlspecialchars($apprenant['photo']) ?>" alt="">
                        </div>
                        <div class="ml-4">
                          <div class="text-sm font-medium text-gray-900">
                            <?= htmlspecialchars($apprenant['prenom'] . ' ' . $apprenant['nom']) ?>
                          </div>
                          <div class="text-sm text-gray-500">
                            <?= htmlspecialchars($apprenant['email']) ?>
                          </div>
                        </div>
                      </div>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php else: ?>
              <p class="text-gray-500 text-center py-4">Aucun apprenant dans cette promotion</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

<script>
function confirmerSuppression(id) {
  if (confirm('Êtes-vous sûr de vouloir supprimer cette promotion ?')) {
    window.location.href = `?controllers=promotion&action=delete&id=${id}`;
  }
}
</script> 