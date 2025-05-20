<div class="flex h-screen">
  <main class="flex-1">
    <div class="p-6 overflow-y-auto">
      <div class="max-w-3xl mx-auto bg-[#F9EFEF] rounded-xl p-6">
        <div class="mb-6">
          <h1 class="text-2xl font-bold text-[#F9CF98]">Modifier la promotion</h1>
          <p class="text-sm text-gray-500">Modifiez les informations de la promotion</p>
        </div>

        <form action="?controllers=promotion&action=update" method="POST" class="space-y-6">
          <input type="hidden" name="id" value="<?= htmlspecialchars($promotion['id']) ?>">
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nom de la promotion -->
            <div>
              <label for="promotion" class="block text-sm font-medium text-gray-700">Nom de la promotion</label>
              <input type="text" name="promotion" id="promotion" required
                value="<?= htmlspecialchars($promotion['promotion']) ?>"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#F9CF98] focus:ring-[#F9CF98]">
            </div>

            <!-- Référentiel -->
            <div>
              <label for="referentiel" class="block text-sm font-medium text-gray-700">Référentiel</label>
              <select name="referentiel" id="referentiel" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#F9CF98] focus:ring-[#F9CF98]">
                <option value="">Sélectionner un référentiel</option>
                <?php foreach ($referentiels as $ref): ?>
                  <option value="<?= htmlspecialchars($ref['id']) ?>" 
                    <?= $ref['id'] == $promotion['referentiel'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($ref['nom']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Date de début -->
            <div>
              <label for="date_debut" class="block text-sm font-medium text-gray-700">Date de début</label>
              <input type="date" name="date_debut" id="date_debut" required
                value="<?= htmlspecialchars($promotion['date_debut']) ?>"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#F9CF98] focus:ring-[#F9CF98]">
            </div>

            <!-- Date de fin -->
            <div>
              <label for="date_fin" class="block text-sm font-medium text-gray-700">Date de fin</label>
              <input type="date" name="date_fin" id="date_fin" required
                value="<?= htmlspecialchars($promotion['date_fin']) ?>"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#F9CF98] focus:ring-[#F9CF98]">
            </div>

            <!-- Statut -->
            <div>
              <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
              <select name="statut" id="statut" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#F9CF98] focus:ring-[#F9CF98]">
                <option value="active" <?= $promotion['statut'] == 'active' ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= $promotion['statut'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
              </select>
            </div>
          </div>

          <div class="flex justify-end space-x-4">
            <a href="?controllers=promotion&page=listePromotion" 
              class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
              Annuler
            </a>
            <button type="submit"
              class="px-4 py-2 bg-[#F9CF98] text-[#87520E] rounded-md hover:bg-[#87520E] hover:text-[#F9CF98] transition">
              Enregistrer les modifications
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>
</div> 