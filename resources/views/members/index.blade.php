@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-semibold">Daftar Anggota</h2>
        <a href="{{ route('members.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah Anggota</a>
    </div>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Nama</th>
                <th class="border p-2">Email</th>
                <th class="border p-2">Telepon</th>
                <th class="border p-2">Alamat</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($members as $member)
                <tr>
                    <td class="border p-2">{{ $member->name }}</td>
                    <td class="border p-2">{{ $member->email }}</td>
                    <td class="border p-2">{{ $member->phone ?? '-' }}</td>
                    <td class="border p-2">{{ $member->address ?? '-' }}</td>
                    <td class="border p-2">
                        <a href="{{ route('members.edit', $member->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="border p-2 text-center">Belum ada anggota.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection