<div class="flex h-screen">
  <main class="flex-1 p-6 overflow-y-auto">
    <div class="max-w-4xl mx-auto">
      <!-- En-tête -->
      <div class="flex justify-between items-center mb-6">
        <div>
          <h1 class="text-2xl font-bold text-gray-800">Détails de l'apprenant</h1>
          <p class="text-gray-600">Informations complètes sur l'apprenant</p>
        </div>
        <div class="flex space-x-2">
          <a href="?controllers=apprenant&page=modifier&id=<?= $apprenant['id'] ?>" 
             class="btn btn-primary">
            <i class="ri-edit-line mr-2"></i> Modifier
          </a>
          <a href="?controllers=apprenant&page=listeApprenants" 
             class="btn btn-ghost">
            <i class="ri-arrow-left-line mr-2"></i> Retour
          </a>
        </div>
      </div>

      <!-- Carte principale -->
      <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
          <div class="flex items-start space-x-6">
            <!-- Photo de profil -->
            <div class="flex-shrink-0">
              <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-gray-200">
                <img src="<?= $apprenant['photo'] ? 'data:image/jpeg;base64,' . base64_encode($apprenant['photo']) : 'assets/images/default-avatar.png' ?>"
                     alt="Photo de <?= htmlspecialchars($apprenant['nom']) ?>"
                     class="w-full h-full object-cover">
              </div>
            </div>

            <!-- Informations principales -->
            <div class="flex-1">
              <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">
                  <?= htmlspecialchars($apprenant['prenom'] . ' ' . $apprenant['nom']) ?>
                </h2>
                <span class="badge badge-lg badge-<?= $apprenant['statut'] === 'Actif' ? 'success' : 'error' ?>">
                  <?= htmlspecialchars($apprenant['statut']) ?>
                </span>
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div>
                  <p class="text-sm text-gray-500">Matricule</p>
                  <p class="font-medium"><?= htmlspecialchars($apprenant['matricule']) ?></p>
                </div>
                <div>
                  <p class="text-sm text-gray-500">Classe</p>
                  <p class="font-medium"><?= htmlspecialchars($apprenant['classe']) ?></p>
                </div>
                <div>
                  <p class="text-sm text-gray-500">Email</p>
                  <p class="font-medium"><?= htmlspecialchars($apprenant['email']) ?></p>
                </div>
                <div>
                  <p class="text-sm text-gray-500">Téléphone</p>
                  <p class="font-medium"><?= htmlspecialchars($apprenant['telephone']) ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Informations supplémentaires -->
        <div class="border-t border-gray-200">
          <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informations supplémentaires</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Historique des statuts -->
              <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-medium text-gray-700 mb-2">Historique des statuts</h4>
                <div class="space-y-2">
                  <?php
                  // À implémenter : récupération de l'historique des statuts
                  $historique = []; // getHistoriqueStatuts($apprenant['id']);
                  if (empty($historique)): ?>
                    <p class="text-gray-500 text-sm">Aucun historique disponible</p>
                  <?php else: ?>
                    <?php foreach ($historique as $statut): ?>
                      <div class="flex items-center justify-between text-sm">
                        <span><?= htmlspecialchars($statut['statut']) ?></span>
                        <span class="text-gray-500"><?= htmlspecialchars($statut['date']) ?></span>
                      </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              </div>

              <!-- Notes et observations -->
              <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-medium text-gray-700 mb-2">Notes et observations</h4>
                <div class="space-y-2">
                  <?php
                  // À implémenter : récupération des notes et observations
                  $notes = []; // getNotes($apprenant['id']);
                  if (empty($notes)): ?>
                    <p class="text-gray-500 text-sm">Aucune note disponible</p>
                  <?php else: ?>
                    <?php foreach ($notes as $note): ?>
                      <div class="text-sm">
                        <p class="text-gray-700"><?= htmlspecialchars($note['contenu']) ?></p>
                        <p class="text-gray-500 text-xs mt-1"><?= htmlspecialchars($note['date']) ?></p>
                      </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</div> 