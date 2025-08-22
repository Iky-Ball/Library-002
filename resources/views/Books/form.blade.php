@extends('layouts.app')

@section('title', isset($book) ? 'Edit Buku' : 'Tambah Buku')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-2xl max-w-lg mx-auto transform transition duration-300 hover:shadow-3xl">
    <h2 class="text-2xl font-semibold text-center text-blue-700 mb-6">{{ isset($book) ? 'Edit Buku' : 'Tambah Buku' }}</h2>
    <form action="{{ isset($book) ? route('books.update', $book->id) : route('books.store') }}" method="POST" class="space-y-4">
        @csrf
        @if(isset($book)) @method('PUT') @endif
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
            <input type="text" name="title" id="title" value="{{ old('title', $book->title ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror" required>
            @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label for="author" class="block text-sm font-medium text-gray-700">Penulis</label>
            <input type="text" name="author" id="author" value="{{ old('author', $book->author ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('author') border-red-500 @enderror" required>
            @error('author') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label for="isbn" class="block text-sm font-medium text-gray-700">ISBN</label>
            <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('isbn') border-red-500 @enderror" required>
            @error('isbn') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label for="published_year" class="block text-sm font-medium text-gray-700">Tahun Terbit</label>
            <input type="number" name="published_year" id="published_year" value="{{ old('published_year', $book->published_year ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('published_year') border-red-500 @enderror">
            @error('published_year') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label for="total_copies" class="block text-sm font-medium text-gray-700">Total Salinan</label>
            <input type="number" name="total_copies" id="total_copies" value="{{ old('total_copies', $book->total_copies ?? 1) }}" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('total_copies') border-red-500 @enderror" required>
            @error('total_copies') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">Simpan</button>
        </div>
    </form>
</div>
@endsection