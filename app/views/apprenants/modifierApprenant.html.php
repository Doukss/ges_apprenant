<?php
$classes = getClasses();
$statuts = getStatuts();
?>

<div class="flex h-screen">
  <main class="flex-1 p-6 overflow-y-auto">
    <div class="max-w-4xl mx-auto">
      <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
          <div>
            <h1 class="text-2xl font-bold text-gray-800">Modifier l'apprenant</h1>
            <p class="text-gray-600">Modifiez les informations de l'apprenant</p>
          </div>
          <a href="?controllers=apprenant&page=listeApprenants" 
             class="btn btn-ghost">
            <i class="ri-arrow-left-line mr-2"></i> Retour
          </a>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-error mb-4">
            <i class="ri-error-warning-line mr-2"></i>
            <?= htmlspecialchars($_SESSION['error']) ?>
            <?php unset($_SESSION['error']); ?>
          </div>
        <?php endif; ?>

        <form action="?controllers=apprenant&page=modifier&id=<?= $apprenant['id'] ?>" 
              method="POST" 
              enctype="multipart/form-data" 
              class="space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Matricule -->
            <div class="form-control">
              <label class="label">
                <span class="label-text font-medium">Matricule</span>
              </label>
              <input type="text" name="matricule" 
                     value="<?= htmlspecialchars($apprenant['matricule']) ?>"
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
              <input type="text" name="nom" 
                     value="<?= htmlspecialchars($apprenant['nom']) ?>"
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
              <input type="text" name="prenom" 
                     value="<?= htmlspecialchars($apprenant['prenom']) ?>"
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
              <input type="email" name="email" 
                     value="<?= htmlspecialchars($apprenant['email']) ?>"
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
              <input type="tel" name="telephone" 
                     value="<?= htmlspecialchars($apprenant['telephone']) ?>"
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
              <select name="classe" 
                      class="select select-bordered w-full <?= isset($errors['classe']) ? 'select-error' : '' ?>">
                <option value="">Sélectionnez une classe</option>
                <?php foreach ($classes as $classe): ?>
                  <option value="<?= htmlspecialchars($classe) ?>" 
                    <?= $apprenant['classe'] === $classe ? 'selected' : '' ?>>
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
              <select name="statut" 
                      class="select select-bordered w-full <?= isset($errors['statut']) ? 'select-error' : '' ?>">
                <option value="">Sélectionnez un statut</option>
                <?php foreach ($statuts as $statut): ?>
                  <option value="<?= htmlspecialchars($statut) ?>"
                    <?= $apprenant['statut'] === $statut ? 'selected' : '' ?>>
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
              <div class="flex items-center space-x-4">
                <div class="w-20 h-20 rounded-full overflow-hidden border-2 border-gray-200">
                  <img src="<?= $apprenant['photo'] ? 'data:image/jpeg;base64,' . base64_encode($apprenant['photo']) : 'assets/images/default-avatar.png' ?>"
                       alt="Photo de profil"
                       class="w-full h-full object-cover">
                </div>
                <input type="file" name="photo" accept="image/*"
                       class="file-input file-input-bordered w-full <?= isset($errors['photo']) ? 'file-input-error' : '' ?>">
              </div>
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
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
          </div>
        </form>
      </div>
    </div>
  </main>
</div> 