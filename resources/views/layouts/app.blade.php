<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Manajemen Perpustakaan')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #e0f7fa 0%, #ffffff 100%);
        }
        nav {
            transition: all 0.3s ease;
        }
        nav:hover {
            background: #1e40af;
        }
    </style>
</head>
<body class="font-sans">
    <nav class="bg-blue-700 p-4 text-white shadow-lg">
        <div class="container mx-auto flex flex-row justify-between items-center">
            <h1 class="text-2xl font-bold">Manajemen Perpustakaan</h1>
            <div class="space-x-4">
                <a href="{{ route('books.index') }}" class="px-3 py-2 rounded-md hover:bg-blue-600 hover:text-yellow-300 transition duration-300">Buku</a>
                <a href="{{ route('members.index') }}" class="px-3 py-2 rounded-md hover:bg-blue-600 hover:text-green-300 transition duration-300">Anggota</a>
                <a href="{{ route('peminjamans.index') }}" class="px-3 py-2 rounded-md hover:bg-blue-600 hover:text-yellow-300 transition duration-300">Peminjaman</a>
            </div>
        </div>
    </nav>
    <div class="container mx-auto mt-6">
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4 animate-pulse">
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </div>
</body>
</html>