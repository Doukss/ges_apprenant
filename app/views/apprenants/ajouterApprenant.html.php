<?php
$classes = getClasses();
$statuts = getStatuts();
?>

<div class="flex h-screen">
  <main class="flex-1 p-6 overflow-y-auto">
    <div class="max-w-4xl mx-auto">
      <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Ajouter un apprenant</h1>

        <?php if (isset($_SESSION['error'])): ?>
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= htmlspecialchars($_SESSION['error']) ?>
            <?php unset($_SESSION['error']); ?>
          </div>
        <?php endif; ?>

        <form action="?controllers=apprenant&page=ajouter" method="POST" enctype="multipart/form-data" class="space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Matricule -->
            <div class="form-control">
              <label class="label">
                <span class="label-text font-medium">Matricule</span>
              </label>
              <input type="text" name="matricule" value="<?= htmlspecialchars($_POST['matricule'] ?? '') ?>"
                class="input input-bordered w-full <?= isset($errors['matricule']) ? 'input-error' : '' ?>"
                placeholder="Entrez le matricule">
              <?php if (isset($errors['matricule'])): ?>
                <label class="label">
                  <span class="label-text-alt text-error"><?= htmlspecialchars($errors['matricule']) ?></span>
                </label>
              <?php endif; ?>
            </div>

            <!-- Nom -->
            <div class="form-control">
              <label class="label">
                <span class="label-text font-medium">Nom</span>
              </label>
              <input type="text" name="nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>"
                class="input input-bordered w-full <?= isset($errors['nom']) ? 'input-error' : '' ?>"
                placeholder="Entrez le nom">
              <?php if (isset($errors['nom'])): ?>
                <label class="label">
                  <span class="label-text-alt text-error"><?= htmlspecialchars($errors['nom']) ?></span>
                </label>
              <?php endif; ?>
            </div>

            <!-- Prénom -->
            <div class="form-control">
              <label class="label">
                <span class="label-text font-medium">Prénom</span>
              </label>
              <input type="text" name="prenom" value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>"
                class="input input-bordered w-full <?= isset($errors['prenom']) ? 'input-error' : '' ?>"
                placeholder="Entrez le prénom">
              <?php if (isset($errors['prenom'])): ?>
                <label class="label">
                  <span class="label-text-alt text-error"><?= htmlspecialchars($errors['prenom']) ?></span>
                </label>
              <?php endif; ?>
            </div>

            <!-- Email -->
            <div class="form-control">
              <label class="label">
                <span class="label-text font-medium">Email</span>
              </label>
              <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                class="input input-bordered w-full <?= isset($errors['email']) ? 'input-error' : '' ?>"
                placeholder="Entrez l'email">
              <?php if (isset($errors['email'])): ?>
                <label class="label">
                  <span class="label-text-alt text-error"><?= htmlspecialchars($errors['email']) ?></span>
                </label>
              <?php endif; ?>
            </div>

            <!-- Téléphone -->
            <div class="form-control">
              <label class="label">
                <span class="label-text font-medium">Téléphone</span>
              </label>
              <input type="tel" name="telephone" value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>"
                class="input input-bordered w-full <?= isset($errors['telephone']) ? 'input-error' : '' ?>"
                placeholder="Entrez le numéro de téléphone">
              <?php if (isset($errors['telephone'])): ?>
                <label class="label">
                  <span class="label-text-alt text-error"><?= htmlspecialchars($errors['telephone']) ?></span>
                </label>
              <?php endif; ?>
            </div>

            <!-- Classe -->
            <div class="form-control">
              <label class="label">
                <span class="label-text font-medium">Classe</span>
              </label>
              <select name="classe" class="select select-bordered w-full <?= isset($errors['classe']) ? 'select-error' : '' ?>">
                <option value="">Sélectionnez une classe</option>
                <?php foreach ($classes as $classe): ?>
                  <option value="<?= htmlspecialchars($classe) ?>" 
                    <?= (isset($_POST['classe']) && $_POST['classe'] === $classe) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($classe) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <?php if (isset($errors['classe'])): ?>
                <label class="label">
                  <span class="label-text-alt text-error"><?= htmlspecialchars($errors['classe']) ?></span>
                </label>
              <?php endif; ?>
            </div>

            <!-- Statut -->
            <div class="form-control">
              <label class="label">
                <span class="label-text font-medium">Statut</span>
              </label>
              <select name="statut" class="select select-bordered w-full <?= isset($errors['statut']) ? 'select-error' : '' ?>">
                <option value="">Sélectionnez un statut</option>
                <?php foreach ($statuts as $statut): ?>
                  <option value="<?= htmlspecialchars($statut) ?>"
                    <?= (isset($_POST['statut']) && $_POST['statut'] === $statut) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($statut) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <?php if (isset($errors['statut'])): ?>
                <label class="label">
                  <span class="label-text-alt text-error"><?= htmlspecialchars($errors['statut']) ?></span>
                </label>
              <?php endif; ?>
            </div>

            <!-- Photo -->
            <div class="form-control col-span-2">
              <label class="label">
                <span class="label-text font-medium">Photo</span>
              </label>
              <input type="file" name="photo" accept="image/*"
                class="file-input file-input-bordered w-full <?= isset($errors['photo']) ? 'file-input-error' : '' ?>">
              <?php if (isset($errors['photo'])): ?>
                <label class="label">
                  <span class="label-text-alt text-error"><?= htmlspecialchars($errors['photo']) ?></span>
                </label>
              <?php endif; ?>
            </div>
          </div>

          <div class="flex justify-end space-x-4 mt-6">
            <a href="?controllers=apprenant&page=listeApprenants" 
               class="btn btn-ghost">Annuler</a>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
          </div>
        </form>
      </div>
    </div>
  </main>
</div> 