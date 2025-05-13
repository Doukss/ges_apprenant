 <!-- Sidebar -->
 <aside class="w-64  text-gray-500 p-4 flex flex-col h-full  bg-gray-50 text-gray-900 w-64 lg:w-52 md:flex transform transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 z-50">
   <div class="text-center mb-6">
     <div class="bg-white p-2 w-20 mx-auto rounded-2xl">
       <img src="assets/images/logo.png" alt="Logo" class="w-14 mx-auto mb-2">
     </div>
     <div class="mt-2">
       <span class="text-sm bg-[#F9CF98] text-[#87520E] px-2 py-1 rounded">Promotion <?= date("Y", strtotime("now")) ?></span>
     </div>
     <hr class="my-4">
   </div>
   <nav class="flex-1 space-y-6 text-sm">
     <a href="" class="flex items-center gap-2 hover:text-500"><i class="ri-dashboard-line"></i> Tableau de bord</a>
     <a href="" class="flex items-center gap-2 text-gray-500 font-bold h-10 bg-red-600 text-white shadow-xl : hover:bg-[#F9CF98] rounded-full"><i class="ri-group-line"></i> Promotions</a>
     <a href="#" class="flex items-center gap-2 text-gray-500"><i class="ri-booklet-line"></i> Referentiels</a>
   </nav>
   <a href="<?= WEBROOB ?>?controllers=login&page=deconnexion" class="mt-auto bg-white text-red-700 py-2 rounded flex items-center justify-center gap-2">
     <button>
       <i class="ri-logout-box-r-line "></i> Déconnexion
     </button>
   </a>

 </aside>