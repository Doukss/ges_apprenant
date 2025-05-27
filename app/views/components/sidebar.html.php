<!-- Sidebar -->
<aside class="w-64  text-gray-500 p-4 flex flex-col h-full  bg-gray-50 text-gray-900 w-64 lg:w-52 md:flex transform transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 z-50">
  <div class="text-center mb-6">
    <div class="bg-white p-2 w-20 mx-auto shadow-xl rounded-2xl">
      <img src="assets/images/logo.png" alt="Logo" class="w-14 mx-auto mb-2">
    </div>
    <div class="mt-2">
      <span class="text-sm bg-[#F9CF98] text-[#87520E] px-2 py-1 rounded">Promotion <?= date("Y", strtotime("now")) ?></span>
    </div>
    <hr class="my-4">
  </div>

  <!-- Navigation Links -->
  <nav class="flex-1">
    <ul class="space-y-2">
      <li>
        <a href="<?= WEBROOB ?>?controllers=referentiel&page=listeReferentiel" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-200">
          <i class="ri-book-2-line"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li>
        <a href="<?= WEBROOB ?>?controllers=promotion&page=listepromotion" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-200">
          <i class="ri-group-line"></i>
          <span>Promotion</span>
        </a>
      </li>
      <li>
        <a href="<?= WEBROOB ?>?controllers=referentiel&page=listeReferentiel" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-200">
          <i class="ri-book-2-line"></i>
          <span>Référentiel</span>
        </a>
      </li>
      <li>
        <a href="<?= WEBROOB ?>?controllers=apprenant&page=listeApprenants" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-200">
          <i class="ri-user-line"></i>
          <span>Apprenants</span>
        </a>
      </li>
    </ul>
  </nav>

  <a href="<?= WEBROOB ?>?controllers=login&page=deconnexion" class="mt-auto bg-red-100 text-red-600 py-2 rounded flex items-center justify-center gap-2">
    <button>
      <i class="ri-logout-box-r-line "></i> Déconnexion
    </button>
  </a>

</aside>