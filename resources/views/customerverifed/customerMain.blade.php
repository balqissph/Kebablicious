@extends('customerverifed.master')
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
          <a href="{{ route('menukebablicious') }}"
            class="flex items-center space-x-3 text-gray-700 hover:text-orange-500">
            <span class="material-icons">restaurant</span>
            <span>Menu</span>
          </a>
          <a href="{{ route('keranjang') }}" class="flex items-center space-x-3 text-gray-700 hover:text-orange-500">
            <span class="material-icons">shopping_cart</span>
            <span>Keranjang</span>
          </a>
          @can('manage menus')
        <a href="{{ route('admin.dashboard') }}"
        class="flex items-center space-x-3 text-gray-700 hover:text-orange-500">
        <span class="material-icons">admin_panel_settings</span>
        <span>Akun</span>
        </a>
      @endcan
        </nav>
      </div>

      <!-- Logout Form -->
      <form method="POST" action="{{ route('logout') }}" class="mt-8">
        @csrf
        <button type="submit" class="flex items-center space-x-3 text-gray-700 hover:text-orange-500">
          <span class="material-icons">logout</span>
          <span>Logout</span>
        </button>
      </form>
    </div>

    <!-- Main Content -->
    <main class="flex-1 p-4 sm:p-6 relative md:ml-64 pb-6">
      <!-- Toggle Button for Mobile Sidebar -->
      <button id="toggleSidebar" class="block md:hidden text-gray-700 hover:text-orange-500 focus:outline-none mb-4">
        <span class="material-icons">menu</span>
      </button>

      <header class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
        <h2 class="text-lg xs:text-xl sm:text-2xl font-bold text-center sm:text-left"></h2>

        <div class="flex items-center space-x-4 w-full sm:w-auto">
        </div>

        @auth
      <div class="relative group text-sm sm:text-base">
        <span class="cursor-pointer font-semibold text-gray-800">{{ Auth::user()->name }}</span>
        <div class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg hidden group-hover:block">
        <a href="{{ url('profile') }}"
          class="block px-4 py-2 text-gray-700 hover:bg-gray-100">{{ __('Profile') }}</a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit"
          class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
        </form>
        </div>
      </div>
    @endauth
      </header>
    </main>
  </div>

  <!-- Material Icons CDN -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!-- Script to Toggle Sidebar -->
  <script>
    const toggleSidebar = document.getElementById("toggleSidebar");
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");

    toggleSidebar.addEventListener("click", () => {
      sidebar.classList.toggle("-translate-x-full");
      overlay.classList.toggle("hidden");
    });

    overlay.addEventListener("click", () => {
      sidebar.classList.add("-translate-x-full");
      overlay.classList.add("hidden");
    });
  </script>
</body>