@extends('customer.master')
@section('konten')

<body class="bg-gray-100">
  <div id="overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40"></div>

  <div class="flex flex-col md:flex-row min-h-screen">
    <!-- Sidebar -->
    <div
      class="w-full md:w-64 bg-white shadow-md p-6 flex flex-col justify-between fixed md:relative z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out"
      id="sidebar">
      <div>
        <!-- Logo -->
        <div class="text-orange-500 text-2xl font-bold mb-6 text-center md:text-left">
          kebab <br> delicios
        </div>

        <!-- Navigation -->
        <nav class="space-y-4">
          <a href="#" onclick="showLoginModal(event)"
            class="flex items-center space-x-3 text-gray-700 hover:text-orange-500">
            <span class="material-icons">restaurant</span>
            <span>Menu</span>
          </a>
          <a href="#" onclick="showLoginModal(event)"
            class="flex items-center space-x-3 text-gray-700 hover:text-orange-500">
            <span class="material-icons">shopping_cart</span>
            <span>Keranjang</span>
          </a>
        </nav>
      </div>

      <!-- Logout Form -->
      <form method="POST" action="#" class="mt-8">
        <button type="button" onclick="showLoginModal(event)"
          class="flex items-center space-x-3 text-gray-700 hover:text-orange-500">
        </button>
      </form>
    </div>

    <!-- Main Content -->
    <main class="flex-1 p-6 relative md:ml-64 pb-6">
      <!-- Toggle Button for Mobile Sidebar -->
      <button id="toggleSidebar" class="block md:hidden text-gray-700 hover:text-orange-500 focus:outline-none mb-4">
        <span class="material-icons">menu</span>
      </button>

      <header class="flex justify-between items-center">
        <h2 class="text-2xl font-bold"></h2>
        <div class="flex items-center space-x-4">
          <a href="{{url('/login')}}" class="px-4 py-2 bg-orange-500 text-white rounded-lg text-center">LOG IN</a>
          <a href="{{url('/register')}}"
            class="px-4 py-2 border border-orange-500 text-orange-500 rounded-lg">Signup</a>
        </div>
      </header>
    </main>

    <!-- Modal -->
    <div id="modal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
      <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <h3 id="modal-title" class="text-xl font-bold text-center mb-4">Anda perlu login terlebih dahulu</h3>
        <div class="flex flex-col space-y-4">
          <a href="{{url('/login')}}" class="px-4 py-2 bg-orange-500 text-white rounded-lg w-full text-center">Login</a>
          <a href="{{url('/register')}}"
            class="px-4 py-2 border border-orange-500 text-orange-500 rounded-lg w-full text-center">Signup</a>
        </div>
        <button onclick="toggleModal()" class="mt-6 px-4 py-2 bg-red-500 text-white rounded-lg w-full">Cancel</button>
      </div>
    </div>

  </div>

  <!-- Material Icons CDN -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!-- Script to Toggle Sidebar and Modal -->
  <script>
    const toggleSidebar = document.getElementById("toggleSidebar");
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");
    const modal = document.getElementById("modal");

    toggleSidebar.addEventListener("click", () => {
      sidebar.classList.toggle("-translate-x-full");
      overlay.classList.toggle("hidden");
    });

    overlay.addEventListener("click", () => {
      sidebar.classList.add("-translate-x-full");
      overlay.classList.add("hidden");
    });

    function toggleModal() {
      modal.classList.toggle("hidden");
    }

    function showLoginModal(event) {
      event.preventDefault();
      toggleModal();
    }
  </script>
</body>

@endsection