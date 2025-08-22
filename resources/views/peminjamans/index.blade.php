@extends('layouts.app')

@section('title', 'Daftar Peminjaman')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-2xl">
    <div class="flex justify-between mb-4">
        <h2 class="text-2xl font-semibold text-yellow-700">Daftar Peminjaman</h2>
        <a href="{{ route('peminjamans.create') }}" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition duration-300 flex items-center">
            <i class="fas fa-plus mr-2"></i> Ajukan Peminjaman
        </a>
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
                    <th class="border p-3 text-left text-yellow-800">Buku</th>
                    <th class="border p-3 text-left text-yellow-800">Anggota</th>
                    <th class="border p-3 text-left text-yellow-800">Tgl Kembali</th>
                    <th class="border p-3 text-left text-yellow-800">Status</th>
                    <th class="border p-3 text-left text-yellow-800">Catatan</th>
                    <th class="border p-3 text-left text-yellow-800">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjamans as $peminjaman)
                    <tr class="hover:bg-gray-100 transition duration-200 {{ $peminjaman->status == 'approved' ? 'bg-green-100' : ($peminjaman->status == 'returned' ? 'bg-yellow-100' : 'bg-blue-100') }}">
                        <td class="border p-3">{{ $peminjaman->book->title ?? 'Tidak ada judul' }}</td>
                        <td class="border p-3">{{ $peminjaman->member->name ?? 'Tidak ada nama' }}</td>
                        <td class="border p-3">{{ $peminjaman->due_date ? $peminjaman->due_date->format('d-m-Y') : '-' }}</td>
                        <td class="border p-3">{{ ucfirst($peminjaman->status) ?? 'Tidak diketahui' }}</td>
                        <td class="border p-3">{{ $peminjaman->notes ?? '-' }}</td>
                        <td class="border p-3 space-x-2">
                            <a href="{{ route('peminjamans.edit', $peminjaman->id) }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('peminjamans.destroy', $peminjaman->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 flex items-center" onclick="return confirm('Yakin hapus?')">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                            @if($peminjaman->status == 'requested')
                                <form action="{{ route('peminjamans.approve', $peminjaman->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-800 flex items-center">
                                        <i class="fas fa-check mr-1"></i> Approve
                                    </button>
                                </form>
                            @elseif($peminjaman->status == 'approved')
                                <form action="{{ route('peminjamans.return', $peminjaman->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-yellow-600 hover:text-yellow-800 flex items-center">
                                        <i class="fas fa-undo mr-1"></i> Kembalikan
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="border p-3 text-center text-gray-500">Belum ada peminjaman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection