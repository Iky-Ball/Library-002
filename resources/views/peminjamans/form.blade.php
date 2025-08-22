@extends('layouts.app')

@section('title', isset($peminjaman) ? 'Edit Peminjaman' : 'Ajukan Peminjaman')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-2xl max-w-lg mx-auto transform transition duration-300 hover:shadow-3xl">
    <h2 class="text-2xl font-semibold text-center text-yellow-700 mb-6">{{ isset($peminjaman) ? 'Edit Peminjaman' : 'Ajukan Peminjaman' }}</h2>
    <form action="{{ isset($peminjaman) ? route('peminjamans.update', $peminjaman->id) : route('peminjamans.store') }}" method="POST" class="space-y-4">
        @csrf
        @if(isset($peminjaman)) @method('PUT') @endif
        <div class="mb-4">
            <label for="book_id" class="block text-sm font-medium text-gray-700">Buku</label>
            <select name="book_id" id="book_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 @error('book_id') border-red-500 @enderror" required>
                <option value="">Pilih Buku</option>
                @foreach ($books as $book)
                    <option value="{{ $book->id }}" {{ old('book_id', $peminjaman->book_id ?? '') == $book->id ? 'selected' : '' }}>{{ $book->title }} (Tersedia: {{ $book->available_copies }})</option>
                @endforeach
            </select>
            @error('book_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label for="member_id" class="block text-sm font-medium text-gray-700">Anggota</label>
            <select name="member_id" id="member_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 @error('member_id') border-red-500 @enderror" required>
                <option value="">Pilih Anggota</option>
                @foreach ($members as $member)
                    <option value="{{ $member->id }}" {{ old('member_id', $peminjaman->member_id ?? '') == $member->id ? 'selected' : '' }}>{{ $member->name }} ({{ $member->email }})</option>
                @endforeach
            </select>
            @error('member_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label for="due_date" class="block text-sm font-medium text-gray-700">Tanggal Kembali</label>
            <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $peminjaman->due_date ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 @error('due_date') border-red-500 @enderror" required>
            @error('due_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label for="notes" class="block text-sm font-medium text-gray-700">Catatan</label>
            <textarea name="notes" id="notes" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 @error('notes') border-red-500 @enderror">{{ old('notes', $peminjaman->notes ?? '') }}</textarea>
            @error('notes') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition duration-300">Simpan</button>
        </div>
    </form>
</div>
@endsection