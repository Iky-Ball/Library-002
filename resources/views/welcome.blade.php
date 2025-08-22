@extends('layouts.app')

@section('title', 'Dashboard Perpustakaan')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-2xl max-w-4xl mx-auto">
    <h2 class="text-3xl font-bold text-center text-blue-700 mb-6">Selamat Datang di Manajemen Perpustakaan</h2>
    <p class="text-center text-gray-600 mb-8">Kelola buku, anggota, dan peminjaman dengan mudah.</p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('books.index') }}" class="bg-blue-100 p-6 rounded-lg shadow-md hover:shadow-xl hover:bg-blue-200 transition duration-300 transform hover:-translate-y-2">
            <h3 class="text-xl font-medium text-blue-800">📚 Kelola Buku</h3>
            <p class="mt-2 text-gray-600">Lihat, tambah, atau edit daftar buku.</p>
        </a>
        <a href="{{ route('members.index') }}" class="bg-green-100 p-6 rounded-lg shadow-md hover:shadow-xl hover:bg-green-200 transition duration-300 transform hover:-translate-y-2">
            <h3 class="text-xl font-medium text-green-800">👤 Kelola Anggota</h3>
            <p class="mt-2 text-gray-600">Tambah atau edit data anggota perpustakaan.</p>
        </a>
        <a href="{{ route('peminjamans.index') }}" class="bg-yellow-100 p-6 rounded-lg shadow-md hover:shadow-xl hover:bg-yellow-200 transition duration-300 transform hover:-translate-y-2">
            <h3 class="text-xl font-medium text-yellow-800">🔄 Kelola Peminjaman</h3>
            <p class="mt-2 text-gray-600">Ajukan, setujui, atau kembalikan peminjaman.</p>
        </a>
    </div>
</div>
@endsection