@extends('layouts.app')

@section('title', isset($peminjaman) ? 'Edit Peminjaman' : 'Ajukan Peminjaman')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
    <h2 class="text-xl font-semibold mb-4">{{ isset($peminjaman) ? 'Edit Peminjaman' : 'Ajukan Peminjaman' }}</h2>
    <form action="{{ isset($peminjaman) ? route('peminjamans.update', $peminjaman->id) : route('peminjamans.store') }}" method="POST">
        @csrf
        @if(isset($peminjaman)) @method('PUT') @endif
        <div class="mb-4">
            <label for="book_id" class="block text-sm font-medium text-gray-700">Buku</label>
            <select name="book_id" id="book_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('book_id') border-red-500 @enderror" required>
                <option value="">Pilih Buku</option>
                @foreach ($books as $book)
                    <option value="{{ $book->id }}" {{ old('book_id', $peminjaman->book_id ?? '') == $book->id ? 'selected' : '' }}>{{ $book->title }} (Tersedia: {{ $book->available_copies }})</option>
                @endforeach
            </select>
            @error('book_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label for="member_id" class="block text-sm font-medium text-gray-700">Anggota</label>
            <select name="member_id" id="member_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('member_id') border-red-500 @enderror" required>
                <option value="">Pilih Anggota</option>
                @foreach ($members as $member)
                    <option value="{{ $member->id }}" {{ old('member_id', $peminjaman->member_id ?? '') == $member->id ? 'selected' : '' }}>{{ $member->name }} ({{ $member->email }})</option>
                @endforeach
            </select>
            @error('member_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label for="due_date" class="block text-sm font-medium text-gray-700">Tanggal Kembali</label>
            <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $peminjaman->due_date ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('due_date') border-red-500 @enderror" required>
            @error('due_date') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label for="notes" class="block text-sm font-medium text-gray-700">Catatan</label>
            <textarea name="notes" id="notes" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('notes') border-red-500 @enderror">{{ old('notes', $peminjaman->notes ?? '') }}</textarea>
            @error('notes') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection