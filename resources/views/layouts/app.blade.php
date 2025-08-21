<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Manajemen Perpustakaan')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto flex justify-between">
            <h1 class="text-2xl font-bold">Manajemen Perpustakaan</h1>
            <div>
                <a href="{{ route('books.index') }}" class="mx-2">Buku</a>
                <a href="{{ route('members.index') }}" class="mx-2">Anggota</a>
                <a href="{{ route('peminjamans.index') }}" class="mx-2">Peminjaman</a>
            </div>
        </div>
    </nav>
    <div class="container mx-auto mt-6">
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </div>
</body>
</html>