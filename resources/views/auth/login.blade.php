<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Peminjaman Pradita</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-6">Peminjaman Lapangan Pradita</h1>
        <p class="text-center text-gray-500 mb-6">Silakan login untuk melanjutkan</p>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <div class="mb-4">
                <label for="nama_user" class="block text-sm font-medium text-gray-700 mb-1">Nama User</label>
                <input type="text" name="nama_user" id="nama_user" value="{{ old('nama_user') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" id="password"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                Login
            </button>
        </form>

        <div class="mt-6 text-sm text-gray-500">
            <p class="font-medium mb-1">Akun Demo:</p>
            <p>Admin: <strong>Admin BM</strong> / admin123</p>
            <p>Mahasiswa: <strong>Budi Santoso</strong> / mahasiswa123</p>
        </div>
    </div>

</body>
</html>
