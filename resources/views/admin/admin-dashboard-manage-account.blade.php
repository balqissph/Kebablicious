<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelanggan</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                    <a href=""onclick="event.preventDefault(); window.location.replace('{{ route('menu') }}')"
                        class="flex items-center space-x-3 text-gray-700 hover:text-orange-500">
                        <span class="material-icons">restaurant</span>
                        <span>Manage Menu</span>
                    </a>


                    <a href=""onclick="event.preventDefault(); window.location.replace('{{ route('user') }}')"
                        class="flex items-center space-x-3 text-gray-700 hover:text-orange-500">
                        <span class="material-icons">account_circle</span>
                        <span>Manage Akun</span>
                    </a>


                    <a href=""
                        ,onclick="event.preventDefault(); window.location.replace('{{ route('admin.dashboard') }}')"
                        class="flex items-center space-x-3 text-gray-700 hover:text-orange-500">
                        <span class="material-icons">close</span>
                        <span>Keluar</span>
                    </a>
                </nav>
            </div>
            <a href="#" class="flex items-center space-x-2 text-gray-700 hover:text-orange-500">
                <span class="material-icons text-lg">logout</span>
                <span class="text-sm">Logout</span>
            </a>
        </div>

        <!-- Content -->

        <div class="flex-1 p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Daftar Pelanggan</h1>
            <div class="bg-white shadow rounded-lg p-6">
                <!-- Customer List -->
                @foreach ($posts as $tampil)
                    <div class="flex items-center justify-between py-4 border-b">
                        <div class="flex items-center space-x-4 p-4 bg-gray-100 rounded-lg shadow">
                            <div
                                class="flex items-center justify-center w-12 h-12 bg-blue-500 text-white rounded-full font-bold">
                                {{$tampil->id}}
                            </div>
                            <div>
                                <p class="text-gray-800 font-semibold text-lg">{{$tampil->name}}</p>
                                <p class="text-gray-700">{{$tampil->email}}</p>
                                <p class="text-gray-500 text-sm">PASSWORD {{$tampil->password}}</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button onclick="openModal()"
                                class="px-4 py-2  bg-orange-500 text-white rounded shadow hover:bg-orange-600">TAMBAH
                                ROLE</button>
                            <button onclick="openModalhapus()"
                                class="px-4 py-2 bg-red-500 text-white rounded shadow hover:bg-red-600">HAPUS ROLE</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- MODAL UNTUK MENETAPKAN ROLE -->
    <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <h3 class="text-lg font-bold mb-4">TETAPKAN ROLE ADMIN</h3>
            <form action="{{ route('tambahrole') }}" method="post" enctype="multipart/form-data">
                @csrf
                <!-- <div class="mb-4">
                                                                <label for="nama" class="block text-sm font-medium text-gray-700">role_id</label>
                                                                <input type="text" name="role_id" id="role_id" value="1" disabled
                                                                    class="block w-full px-3 py-2 border rounded-lg focus:ring-orange-500 focus:border-orange-500"
                                                                    required>
                                                            </div>
                                                            <div class="mb-4">
                                                                <label for="harga" class="block text-sm font-medium text-gray-700">model_type
                                                                </label>
                                                                <input type="text" name="model_type" id="modal_type" value="App\Models\User" disabled
                                                                    class="block w-full px-3 py-2 border rounded-lg focus:ring-orange-500 focus:border-orange-500"
                                                                    required>
                                                            </div> -->
                <div class="mb-4">
                    <label for="model_id" class="block text-sm font-medium text-gray-700">ID AKUN
                    </label>
                    <input type="number" name="model_id" id="model_id"
                        class="block w-full px-3 py-2 border rounded-lg focus:ring-orange-500 focus:border-orange-500"
                        required>
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

    <div id="modalhapus" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <h3 class="text-lg font-bold mb-4">HAPUS ROLE ADMIN ?</h3>
            <form action="{{ route('hapusrole') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('DELETE')
                <div class="mb-4">
                    <label for="model_id" class="block text-sm font-medium text-gray-700">ID AKUN
                    </label>
                    <input type="text" name="model_id" id="model_id"
                        class="block w-full px-3 py-2 border rounded-lg focus:ring-orange-500 focus:border-orange-500"
                        required>
                </div>
                <form action="{{route('hapusrole')}}">
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeModalhapus()"
                            class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-orange-500 text-white font-semibold rounded-md hover:bg-orange-600">HAPUS
                            ROLE</button>
                    </div>
                </form>
            </form>
        </div>
    </div>
    <!-- MODAL UNTUK DELETE ROLE -->

    <!-- CDN -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script>
        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        function openModalhapus() {
            document.getElementById('modalhapus').classList.remove('hidden');
        }

        function closeModalhapus() {
            document.getElementById('modalhapus').classList.add('hidden');
        }
    </script>
</body>

</html>