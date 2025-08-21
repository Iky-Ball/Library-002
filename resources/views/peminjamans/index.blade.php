@extends('layouts.app')

@section('title', 'Daftar Peminjaman')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-semibold">Daftar Peminjaman</h2>
        <a href="{{ route('peminjamans.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ajukan Peminjaman</a>
    </div>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Buku</th>
                <th class="border p-2">Anggota</th>
                <th class="border p-2">Tgl Kembali</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Catatan</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peminjamans as $peminjaman)
                <tr>
                    <td class="border p-2">{{ $peminjaman->book->title }}</td>
                    <td class="border p-2">{{ $peminjaman->member->name }}</td>
                    <td class="border p-2">{{ $peminjaman->due_date ? $peminjaman->due_date->format('d-m-Y') : '-' }}</td>
                    <td class="border p-2">{{ ucfirst($peminjaman->status) }}</td>
                    <td class="border p-2">{{ $peminjaman->notes ?? '-' }}</td>
                    <td class="border p-2">
                        <a href="{{ route('peminjamans.edit', $peminjaman->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('peminjamans.destroy', $peminjaman->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                        @if($peminjaman->status == 'requested')
                            <form action="{{ route('peminjamans.approve', $peminjaman->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-green-600 hover:underline">Approve</button>
                            </form>
                        @elseif($peminjaman->status == 'approved')
                            <form action="{{ route('peminjamans.return', $peminjaman->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-yellow-600 hover:underline">Kembalikan</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="border p-2 text-center">Belum ada peminjaman.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection