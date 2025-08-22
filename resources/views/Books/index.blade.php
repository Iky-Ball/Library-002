@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-2xl">
    <div class="flex justify-between mb-4">
        <h2 class="text-2xl font-semibold text-blue-700">Daftar Buku</h2>
        <a href="{{ route('books.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">Tambah Buku</a>
    </div>
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4 animate-pulse">
            {{ session('success') }}
        </div>
    @endif
    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-3 text-left text-blue-800">Judul</th>
                    <th class="border p-3 text-left text-blue-800">Penulis</th>
                    <th class="border p-3 text-left text-blue-800">ISBN</th>
                    <th class="border p-3 text-left text-blue-800">Tahun Terbit</th>
                    <th class="border p-3 text-left text-blue-800">Total Salinan</th>
                    <th class="border p-3 text-left text-blue-800">Tersedia</th>
                    <th class="border p-3 text-left text-blue-800">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($books as $book)
                    <tr class="hover:bg-gray-100 transition duration-200">
                        <td class="border p-3">{{ $book->title }}</td>
                        <td class="border p-3">{{ $book->author }}</td>
                        <td class="border p-3">{{ $book->isbn }}</td>
                        <td class="border p-3">{{ $book->published_year ?? '-' }}</td>
                        <td class="border p-3">{{ $book->total_copies }}</td>
                        <td class="border p-3">{{ $book->available_copies }}</td>
                        <td class="border p-3">
                            <a href="{{ route('books.edit', $book->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline ml-2" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="border p-3 text-center text-gray-500">Belum ada buku.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection