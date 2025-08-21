@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-semibold">Daftar Buku</h2>
        <a href="{{ route('books.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah Buku</a>
    </div>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Judul</th>
                <th class="border p-2">Penulis</th>
                <th class="border p-2">ISBN</th>
                <th class="border p-2">Tahun Terbit</th>
                <th class="border p-2">Total Salinan</th>
                <th class="border p-2">Tersedia</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($books as $book)
                <tr>
                    <td class="border p-2">{{ $book->title }}</td>
                    <td class="border p-2">{{ $book->author }}</td>
                    <td class="border p-2">{{ $book->isbn }}</td>
                    <td class="border p-2">{{ $book->published_year ?? '-' }}</td>
                    <td class="border p-2">{{ $book->total_copies }}</td>
                    <td class="border p-2">{{ $book->available_copies }}</td>
                    <td class="border p-2">
                        <a href="{{ route('books.edit', $book->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="border p-2 text-center">Belum ada buku.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection