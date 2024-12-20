<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelanggan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-md p-6 flex flex-col justify-between">
            <div>
                <!-- Logo -->
                <div class="text-orange-500 text-2xl font-bold mb-6">kebab <br> delicios</div>

                <!-- Navigation -->
                <nav class="space-y-4">
                    <a href=""
                        ,onclick="event.preventDefault(); window.location.replace('{{ route('admin.admin-dashboard-manage-menu') }}')"
                        class="flex items-center space-x-3 text-gray-700 hover:text-orange-500">
                        <span class="material-icons">restaurant</span>
                        <span>Manage Menu</span>
                    </a>

                    <a href=""onclick="event.preventDefault(); window.location.replace('{{ route('user') }}')"
                        class="flex items-center space-x-3 text-gray-700 hover:text-orange-500">
                        <span class="material-icons">account_circle</span>
                        <span>Manage Akun</span>
                    </a>

                    <a href="#onclick=" event.preventDefault(); window.location.replace('{{ route('admin.dashboard') }}')" class="flex items-center space-x-3 text-gray-700 hover:text-orange-500">
                        <span class="material-icons">close</span>
                        <span>Keluar</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Content -->
        <main class="flex-1 p-6">
            <header class="mb-6">
                <h2 class="text-2xl font-bold text-gray-700">Daftar Menu</h2>
            </header>

            <div class="mb-6">
                <button onclick="openModal()"
                    class="px-4 py-2 bg-orange-500 text-white font-semibold rounded-md hover:bg-orange-600">
                    Tambah Menu
                </button>
            </div>
            @foreach ($posts as $tampil)
            <!-- Menu List -->
            <div class="space-y-4">
                <!-- Menu Item -->
                    <div class="flex items-center bg-white shadow-sm rounded-md overflow-hidden">
                        <img src="{{$tampil->gambar}}" alt="Menu" class="w-20 h-20 object-cover">
                        <div class="flex-1 p-4">
                            <h3 class="text-lg font-semibold">{{$tampil->nama}}</h3>
                            <p class="text-gray-500">Rp. {{$tampil->harga}}</p>
                            <p class="text-gray-500">{{$tampil->deskripsi}}</p>
                        </div>

                        <div id="modal"
                            class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                                <h3 class="text-lg font-bold mb-4">Tambah Menu</h3>
                                <form action="{{ route('addmenu') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama Menu</label>
                                        <input type="text" name="nama" id="nama"
                                            class="block w-full px-3 py-2 border rounded-lg focus:ring-orange-500 focus:border-orange-500"
                                            required>

                                    </div>
                                    <div class="mb-4">
                                        <label for="harga" class="block text-sm font-medium text-gray-700">Harga
                                            Menu</label>
                                        <input type="number" name="harga" id="harga"
                                            class="block w-full px-3 py-2 border rounded-lg focus:ring-orange-500 focus:border-orange-500"
                                            required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi
                                            Menu</label>
                                        <input type="text" name="deskripsi" id="deskripsi"
                                            class="block w-full px-3 py-2 border rounded-lg focus:ring-orange-500 focus:border-orange-500"
                                            required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar
                                            Menu</label>
                                        <input type="file" name="gambar" id="gambar" accept="image/*"
                                            class="block w-full text-sm text-gray-700 border rounded-lg focus:ring-orange-500 focus:border-orange-500"
                                            onchange="previewImage(event)">
                                        <img id="imagePreview" class="mt-4 w-full h-40 object-cover rounded-lg hidden"
                                            alt="Pratinjau Gambar">
                                    </div>
                                    <div class="flex justify-end space-x-2">
                                        <button type="button" onclick="closeModal()"
                                            class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Batal</button>
                                        <button type="submit"
                                            class="px-4 py-2 bg-orange-500 text-white font-semibold rounded-md hover:bg-orange-600">Tambah</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <!-- Button to trigger the modal -->
                        <button data-modal-target="edit-{{$tampil->id}}" data-modal-toggle="edit-{{$tampil->id}}"
                            class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mr-3"
                            type="button">
                            EDIT
                        </button>

                        <!-- UPDATE-DATA -->
                        <div id="edit-{{$tampil->id}}" tabindex="-1" aria-hidden="true"
                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div
                                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                            Update produk
                                        </h3>
                                        <button type="button"
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-toggle="edit-{{$tampil->id}}">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>

                                    <!-- Modal body -->
                                    <form action="{{ route('produk.update', ['id' => $tampil->id])}}" method="POST"
                                        class="p-4 md:p-5" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="grid gap-4 mb-4 grid-cols-2">
                                            <div class="col-span-2">
                                                <label for="name-{{$tampil->id}}"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                                                    Menu</label>
                                                <input type="text" name="nama" id="name-{{$tampil->id}}"
                                                    value="{{$tampil->nama}}"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    required="">
                                            </div>
                                            <div class="col-span-2 sm:col-span-1">
                                                <label for="price-{{$tampil->id}}"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga
                                                    Menu</label>
                                                <input type="number" name="harga" id="price-{{$tampil->id}}"
                                                    value="{{$tampil->harga}}"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    required="">
                                            </div>
                                            <div class="col-span-2">
                                                <label for="description-{{$tampil->id}}"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi
                                                    Produk</label>
                                                <textarea id="description-{{$tampil->id}}" rows="4" name="deskripsi"
                                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{$tampil->deskripsi}}</textarea>
                                            </div>
                                            <div class="mb-4">
                                                <label for="gambar-{{$tampil->id}}"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gambar
                                                    Menu</label>
                                                <input type="file" name="gambar" id="gambar-{{$tampil->id}}"
                                                    accept="image/*"
                                                    class="block w-full text-sm text-gray-700 border rounded-lg focus:ring-orange-500 focus:border-orange-500"
                                                    onchange="previewImage(event)">
                                                <img id="imagePreview"
                                                    class="mt-4 w-full h-40 object-cover rounded-lg hidden"
                                                    alt="Pratinjau Gambar">
                                            </div>
                                        </div>

                                        <button type="submit"
                                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            Update produk
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <!-- UNTUK HAPUS DATA -->
                        <button data-modal-target="popup-hapus{{$tampil->id}}"
                            data-modal-toggle="popup-hapus{{$tampil->id}}"
                            class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mr-2"
                            type="button">
                            HAPUS
                        </button>
                        <div id="popup-hapus{{$tampil->id}}" tabindex="-1"
                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <div class="p-4 md:p-5 text-center">
                                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                            APAKAH ANDA YAKIN INGIN MENGHAPUS {{$tampil->nama}} ?</h3>
                                        <form action="{{route('delete', ['id' => $tampil->id])}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button data-modal-hide="popup-hapus{{$tampil->id}}" type="submit"
                                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                YA, SAYA YAKIN </button>
                                            <button data-modal-hide="popup-hapus{{$tampil->id}}" type="button"
                                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                                TIDAK</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-5 flex justify-center">
                {{ $posts->links() }}
            </div>
        </main>
    </div>
    <!-- Modal -->
    <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <h3 class="text-lg font-bold mb-4">Tambah Menu</h3>
            <form action="{{ route('addmenu') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama Menu</label>
                    <input type="text" name="nama" id="nama"
                        class="block w-full px-3 py-2 border rounded-lg focus:ring-orange-500 focus:border-orange-500"
                        required>
                </div>
                <div class="mb-4">
                    <label for="harga" class="block text-sm font-medium text-gray-700">Harga Menu</label>
                    <input type="number" name="harga" id="harga"
                        class="block w-full px-3 py-2 border rounded-lg focus:ring-orange-500 focus:border-orange-500"
                        required>
                </div>
                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Menu</label>
                    <input type="text" name="deskripsi" id="deskripsi"
                        class="block w-full px-3 py-2 border rounded-lg focus:ring-orange-500 focus:border-orange-500"
                        required>
                </div>
                <div class="mb-4">
                    <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar Menu</label>
                    <input type="file" name="gambar" id="gambar" accept="image/*"
                        class="block w-full text-sm text-gray-700 border rounded-lg focus:ring-orange-500 focus:border-orange-500"
                        onchange="previewImage(event)">
                    <img id="imagePreview" class="mt-4 w-full h-40 object-cover rounded-lg hidden"
                        alt="Pratinjau Gambar">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-orange-500 text-white font-semibold rounded-md hover:bg-orange-600">Tambah</button>
                </div>
            </form>

        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        function previewImage(event) {
            const image = document.getElementById('menuImage').files[0];
            const preview = document.getElementById('imagePreview');

            if (image) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };

                reader.readAsDataURL(image);
            } else {
                preview.src = '';
                preview.classList.add('hidden');
            }
        }
    </script>

    <!-- Material Icons CDN -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</body>

</html>