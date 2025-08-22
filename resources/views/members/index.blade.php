@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-2xl">
    <div class="flex justify-between mb-4">
        <h2 class="text-2xl font-semibold text-green-700">Daftar Anggota</h2>
        <a href="{{ route('members.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-300">Tambah Anggota</a>
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
                    <th class="border p-3 text-left text-green-800">Nama</th>
                    <th class="border p-3 text-left text-green-800">Email</th>
                    <th class="border p-3 text-left text-green-800">Telepon</th>
                    <th class="border p-3 text-left text-green-800">Alamat</th>
                    <th class="border p-3 text-left text-green-800">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($members as $member)
                    <tr class="hover:bg-gray-100 transition duration-200">
                        <td class="border p-3">{{ $member->name }}</td>
                        <td class="border p-3">{{ $member->email }}</td>
                        <td class="border p-3">{{ $member->phone ?? '-' }}</td>
                        <td class="border p-3">{{ $member->address ?? '-' }}</td>
                        <td class="border p-3">
                            <a href="{{ route('members.edit', $member->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline ml-2" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="border p-3 text-center text-gray-500">Belum ada anggota.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection