@extends('customerverifed.master')
@section('konten')

<body class="bg-gray-100">
  <div id="overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40"></div>

  <div class="flex min-h-screen">

    <!-- Sidebar -->
    <div class="w-64 bg-white shadow-md p-6 flex flex-col justify-between">
      <div>
        <!-- Logo -->
        <div class="text-orange-500 text-2xl font-bold mb-6">kebab <br> delicios</div>

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

            @can('manage users')
        <a href="{{ route('admin.dashboard') }}"
          class="flex items-center space-x-3 text-gray-700 hover:text-orange-500">
          <span class="material-icons">admin_panel_settings</span>
          <span>Akun</span>
        </a>
      @endcan
          </nav>
      </div>

      <!-- Logout Form -->
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="mt-auto flex items-center space-x-3 text-gray-700 hover:text-orange-500">
          <span class="material-icons">logout</span>
          <span>Logout</span>
        </button>
      </form>
    </div>

    <!-- Main Content -->
    <main class="flex-1 p-6 relative">
      <header class="flex justify-end items-center mr-10">
        @auth
      <div class="relative group">
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


      <!-- Grid Container -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-6">
        @foreach ($kebablicious as $tampil)

      <div class="bg-white rounded-lg shadow-md p-4">
        <!-- Image -->
        <img src="{{ asset('storage/' . $tampil->gambar)}}" alt="Menu"
        class="w-full h-40 object-cover rounded-md mb-4" />

        <h3 class="text-lg font-semibold mb-2">{{ $tampil->nama }}</h3>
        <p class="text-gray-600 text-sm mb-4">
        {{ $tampil->deskripsi }}
        </p>

        <div class="text-lg font-bold text-green-600 mb-4">Rp. {{ $tampil->harga }}</div>

        <form action="{{ route('tambahcart', $tampil->id) }}" method="POST" class="w-full">
        @csrf
        <button type="submit"
          class="w-full bg-orange-500 text-white py-2 rounded-md hover:bg-orange-600 transition">
          Tambah Ke Keranjang
        </button>
        </form>
      </div>
    @endforeach
      </div>
      <div class="mt-5 flex justify-center">
                {{ $kebablicious->links() }}
            </div>
    </main>
  </div>

  <!-- Material Icons CDN -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</body>
@endsection