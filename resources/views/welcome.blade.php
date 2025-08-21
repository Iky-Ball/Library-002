@extends('layouts.app')

@section('title', 'Dashboard Perpustakaan')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Selamat Datang di Manajemen Perpustakaan</h2>
    <p class="mb-4">Kelola buku, anggota, dan peminjaman dengan mudah.</p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('books.index') }}" class="bg-blue-100 p-4 rounded-lg text-center hover:bg-blue-200">
            <h3 class="text-lg font-medium">Kelola Buku</h3>
            <p>Lihat, tambah, atau edit daftar buku.</p>
        </a>
        <a href="{{ route('members.index') }}" class="bg-green-100 p-4 rounded-lg text-center hover:bg-green-200">
            <h3 class="text-lg font-medium">Kelola Anggota</h3>
            <p>Tambah atau edit data anggota perpustakaan.</p>
        </a>
        <a href="{{ route('peminjamans.index') }}" class="bg-yellow-100 p-4 rounded-lg text-center hover:bg-yellow-200">
            <h3 class="text-lg font-medium">Kelola Peminjaman</h3>
            <p>Ajukan, setujui, atau kembalikan peminjaman.</p>
        </a>
    </div>
</div>
@endsection