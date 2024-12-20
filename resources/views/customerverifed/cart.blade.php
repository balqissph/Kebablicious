<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebab Delicios</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">
    <div class="min-h-screen flex">
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

                    <nav class="space-y-4">
                        <a href="" class="flex items-center space-x-3 text-gray-700 hover:text-orange-500">
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
        <main class="flex-1 p-6">
            <!-- Cart Section -->
            <div class="mt-6 bg-white shadow-md rounded-lg overflow-x-auto">
                <div class="p-4 sm:p-6 border-b border-gray-200">
                    <h2 class="text-lg sm:text-xl font-bold">KERANJANG</h2>
                </div>
                <table class="w-full text-left min-w-[600px]">
                    <thead>
                        <tr class="bg-gray-100 text-sm sm:text-base">
                            <th class="py-2 px-3 sm:py-3 sm:px-6">Nama Item</th>
                            <th class="py-2 px-3 sm:py-3 sm:px-6">Harga Satuan</th>
                            <th class="py-2 px-3 sm:py-3 sm:px-6">Kuantitas</th>
                            <th class="py-2 px-3 sm:py-3 sm:px-6">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $cartItem)
                            <tr class="border-b text-sm sm:text-base">
                                <td class="py-3 px-4 sm:py-4 sm:px-6 flex items-center">
                                    <img src="{{ asset('storage/' . $cartItem->product->gambar) }}" alt="Product"
                                        class="w-10 h-10 sm:w-12 sm:h-12 rounded mr-2 sm:mr-4">
                                    <div>
                                        <p class="font-bold">{{ $cartItem->product->nama }}</p>
                                        <p class="text-gray-500 truncate max-w-[150px] sm:max-w-none">
                                            {{ $cartItem->product->deskripsi }}
                                        </p>
                                    </div>
                                </td>
                                <td class="py-3 px-4 sm:py-4 sm:px-6">
                                    Rp. {{ number_format($cartItem->product->harga, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 sm:py-4 sm:px-6 flex items-center">
                                    <input type="number" id="quantity-{{ $cartItem->id }}" value="{{ $cartItem->quantity }}"
                                        min="1"
                                        class="w-10 text-center border border-gray-300 mx-1 sm:mx-2 rounded text-xs sm:text-sm">
                                </td>
                                <td class="py-3 px-4 sm:py-4 sm:px-6">
                                    Rp. {{ number_format($cartItem->product->harga * $cartItem->quantity, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 sm:py-4 sm:px-6 text-center">
                                    <form method="POST" action="{{ route('hapuskeranjang', ['cartId' => $cartItem->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <span class="material-icons text-sm sm:text-base">delete</span>
                                        </button>
                                    </form>
                                    <!-- Tombol Update yang menggunakan id produk untuk JavaScript -->
                                    <button type="button"onclick="updateQuantity({{ $cartItem->id }})"
                                        class="bg-orange-500 text-white px-4 py-2 rounded mt-2">
                                        Update
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="p-4 sm:p-6 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center">
                    <p class="font-bold mb-2 sm:mb-0 text-sm sm:text-base">
                        Total Item ({{ count($cartItems) }}):
                        <span class="text-orange-500">Rp.
                            {{ number_format($cartItems->sum(fn($item) => $item->product->harga * $item->quantity), 0, ',', '.') }}</span>
                    </p>
                    <div class="flex gap-2">
                        <button class="bg-orange-500 text-white px-4 py-2 text-xs sm:text-sm rounded-lg">
                            BELI SEKARANG
                        </button>
                    </div>
                </div>
                <script>
                    function updateQuantity(cartId) {
                        const quantity = document.getElementById(`quantity-${cartId}`).value;

                        fetch(`{{ url('/update-quantity') }}/${cartId}`, { // URL dengan cartId
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ quantity: quantity }),
                        })
                            .then(response => {
                                if (response.ok) {
                                    window.location.reload(); // Reload halaman
                                } else {
                                    alert('Failed to update quantity');
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    }
                </script>
</body>

</html>