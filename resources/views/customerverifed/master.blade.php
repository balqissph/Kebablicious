<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebab Delicios</title>
    <!-- Tambahkan Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Main Content -->
    <main class="">
        @yield('konten')
    </main>

    <!-- Footer -->
    @include('costumerverifedlayouts.footer')

</body>
</html>
