// ... existing code ...
              <?php if (empty($apprenants)): ?>
                <tr>
                  <td colspan="7" class="text-center py-4 text-gray-500">
                    Aucun apprenant trouvé
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($apprenants as $apprenant): ?>
                  <tr>
                    <td>
                      <div class="avatar">
                        <div class="w-12 h-12 rounded-full">
                          <img src="<?= $apprenant['photo'] ? 'data:image/jpeg;base64,' . base64_encode($apprenant['photo']) : 'assets/images/default-avatar.png' ?>"
                               alt="Photo de <?= htmlspecialchars($apprenant['nom']) ?>">
                        </div>
                      </div>
                    </td>
                    <td><?= htmlspecialchars($apprenant['matricule']) ?></td>
                    <td><?= htmlspecialchars($apprenant['nom']) ?></td>
                    <td><?= htmlspecialchars($apprenant['prenom']) ?></td>
                    <td><?= htmlspecialchars($apprenant['classe']) ?></td>
                    <td>
                      <span class="badge badge-<?= $apprenant['statut'] === 'Actif' ? 'success' : 'error' ?>">
                        <?= htmlspecialchars($apprenant['statut']) ?>
                      </span>
                    </td>
                    <td>
                      <div class="flex space-x-2">
                        <a href="?controllers=apprenant&page=details&id=<?= $apprenant['id'] ?>" 
                           class="btn btn-sm btn-info" title="Voir les détails">
                          <i class="ri-eye-line"></i>
                        </a>
                        <a href="?controllers=apprenant&page=modifier&id=<?= $apprenant['id'] ?>" 
                           class="btn btn-sm btn-warning" title="Modifier">
                          <i class="ri-edit-line"></i>
                        </a>
                        <a href="?controllers=apprenant&page=changerStatut&id=<?= $apprenant['id'] ?>" 
                           class="btn btn-sm <?= $apprenant['statut'] === 'Actif' ? 'btn-error' : 'btn-success' ?>" 
                           title="<?= $apprenant['statut'] === 'Actif' ? 'Désactiver' : 'Activer' ?>">
                          <i class="ri-<?= $apprenant['statut'] === 'Actif' ? 'close-circle-line' : 'check-circle-line' ?>"></i>
                        </a>
                        <button onclick="confirmDelete(<?= $apprenant['id'] ?>)" 
                                class="btn btn-sm btn-error" title="Supprimer">
                          <i class="ri-delete-bin-line"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Pagination -->
      <?php if ($total > $perPage): ?>
        <div class="mt-6 flex justify-center">
          <div class="btn-group">
            <?php
            $totalPages = ceil($total / $perPage);
            $startPage = max(1, $currentPage - 2);
            $endPage = min($totalPages, $currentPage + 2);
            ?>
            
            <?php if ($currentPage > 1): ?>
              <a href="?controllers=apprenant&page=listeApprenants&p=<?= $currentPage - 1 ?><?= !empty($filters) ? '&' . http_build_query($filters) : '' ?>" 
                 class="btn btn-sm">Précédent</a>
            <?php endif; ?>

            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
              <a href="?controllers=apprenant&page=listeApprenants&p=<?= $i ?><?= !empty($filters) ? '&' . http_build_query($filters) : '' ?>" 
                 class="btn btn-sm <?= $i === $currentPage ? 'btn-active' : '' ?>">
                <?= $i ?>
              </a>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
              <a href="?controllers=apprenant&page=listeApprenants&p=<?= $currentPage + 1 ?><?= !empty($filters) ? '&' . http_build_query($filters) : '' ?>" 
                 class="btn btn-sm">Suivant</a>
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </main>
</div>

<script>
function confirmDelete(id) {
  if (confirm('Êtes-vous sûr de vouloir supprimer cet apprenant ?')) {
    window.location.href = `?controllers=apprenant&page=supprimer&id=${id}`;
  }
}
</script>