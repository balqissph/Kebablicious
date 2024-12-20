<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kebab Delicios</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function toggleModal(type) {
      const modal = document.getElementById('modal');
      const modalTitle = document.getElementById('modal-title');
      const overlay = document.getElementById('overlay');
      modalTitle.innerText = type === 'login' ? 'Login as' : 'Sign Up as';
      modal.classList.toggle('hidden');
      overlay.classList.toggle('hidden');
    }
  </script>
</head>
<body class="bg-gray-100">

  <div id="overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40"></div>

  <div class="flex h-screen relative">

    <!-- Sidebar -->
    <aside class="bg-gray-200 text-gray-800 w-1/5 flex flex-col items-center py-6 shadow-md z-30">
      <h1 class="text-2xl font-bold mb-8">kebab <span class="text-orange-500">delicios</span></h1>
      <nav class="flex flex-col w-full px-6 space-y-4">
        <a href="#" class="flex items-center px-4 py-2 text-lg rounded-md bg-gray-300 hover:bg-orange-500">
          <span class="material-icons">home</span>
          <span class="ml-3">HOME</span>
        </a>
        <a href="#" class="flex items-center px-4 py-2 text-lg rounded-md hover:bg-orange-500">
          <span class="material-icons">assignment</span>
          <span class="ml-3">PESANAN</span>
        </a>
        <a href="#" class="flex items-center px-4 py-2 text-lg rounded-md hover:bg-orange-500">
          <span class="material-icons">shopping_cart</span>
          <span class="ml-3">KERANJANG</span>
        </a>
      </nav>
      <button class="mt-auto flex items-center px-4 py-2 text-lg rounded-md hover:bg-red-500">
        <span class="material-icons">logout</span>
        <span class="ml-3">LOGOUT</span>
      </button>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 relative">
      <header class="flex justify-between items-center">
        <h2 class="text-2xl font-bold">Daftar makanan</h2>
        <div class="flex items-center space-x-4">
          <input type="text" placeholder="Search" class="px-4 py-2 border rounded-lg">
          <button onclick="toggleModal('login')" class="px-4 py-2 bg-orange-500 text-white rounded-lg">LOG IN</button>
          <button onclick="toggleModal('signup')" class="px-4 py-2 border border-orange-500 text-orange-500 rounded-lg">SIGN UP</button>
        </div>
      </header>

      <!-- Food Grid -->
      <div class="grid grid-cols-4 gap-6 mt-6">
        <!-- Single Food Card -->
        <div class="bg-white rounded-lg shadow-md p-4">
          <img src="https://via.placeholder.com/150" alt="Food" class="w-full h-32 object-cover rounded-lg">
          <h3 class="mt-4 text-lg font-bold">Kebab daging sayur</h3>
          <div class="flex items-center text-orange-500 mt-2">
            <span class="material-icons">star</span>
            <span class="ml-1 text-sm">4.5</span>
          </div>
        </div>
        <!-- Repeat Food Cards -->
        <!-- Duplicate the above div as needed -->
      </div>
    </main>

    <!-- Modal -->
    <div id="modal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
      <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <h3 id="modal-title" class="text-xl font-bold text-center mb-4">Login as</h3>
        <div class="flex flex-col space-y-4">
          <button class="px-4 py-2 bg-orange-500 text-white rounded-lg w-full">Admin</button>
          <button class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg w-full">Pelanggan</button>
        </div>
        <button onclick="toggleModal()" class="mt-6 px-4 py-2 bg-red-500 text-white rounded-lg w-full">Cancel</button>
      </div>
    </div>

  </div>

</body>
</html>
