@extends('layouts.app')

@section('title', isset($member) ? 'Edit Anggota' : 'Tambah Anggota')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
    <h2 class="text-xl font-semibold mb-4">{{ isset($member) ? 'Edit Anggota' : 'Tambah Anggota' }}</h2>
    <form action="{{ isset($member) ? route('members.update', $member->id) : route('members.store') }}" method="POST">
        @csrf
        @if(isset($member)) @method('PUT') @endif
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" name="name" id="name" value="{{ old('name', $member->name ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('name') border-red-500 @enderror" required>
            @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $member->email ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('email') border-red-500 @enderror" required>
            @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">Telepon</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $member->phone ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('phone') border-red-500 @enderror">
            @error('phone') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
            <input type="text" name="address" id="address" value="{{ old('address', $member->address ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('address') border-red-500 @enderror">
            @error('address') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection