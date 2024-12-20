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

                    @can('manage users')
                    <a href=""onclick="event.preventDefault(); window.location.replace('{{ route('user') }}')" 
                    class="flex items-center space-x-3 text-gray-700 hover:text-orange-500">
                        <span class="material-icons">account_circle</span>
                        <span>Manage Akun</span>
                    </a>
                    @endcan

                    <a href=""onclick="event.preventDefault(); window.location.replace('{{ route('dashboard') }}')" 
                    class="flex items-center space-x-3 text-gray-700 hover:text-orange-500">
                        <span class="material-icons">close</span>
                        <span>Keluar</span>
                    </a>
                </nav>
            </div>
            <a href="#" class="flex items-center space-x-3 text-gray-700 hover:text-orange-500">
                <span class="material-icons">logout</span>
                <span>Logout</span>
            </a>
        </div>
    </div>

    <!-- Material Icons CDN -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</body>
</html>
