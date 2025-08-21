<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk approved_by

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['book', 'member', 'approver'])->get();
        return view('peminjamans.index', compact('peminjamans'));
    }

    public function create()
    {
        $books = Book::where('available_copies', '>', 0)->get();
        $members = Member::all();
        return view('peminjamans.form', compact('books', 'members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id'   => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'due_date'  => 'required|date|after:today',
            'notes'     => 'nullable|string',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->available_copies <= 0) {
            return redirect()->back()->withErrors(['book_id' => 'Buku tidak tersedia']);
        }

        $book->decrement('available_copies');

        Peminjaman::create([
            'book_id'     => $request->book_id,
            'member_id'   => $request->member_id,
            'due_date'    => $request->due_date,
            'status'      => 'requested',
            'notes'       => $request->notes,
        ]);

        return redirect()->route('peminjamans.index')->with('success', 'Peminjaman berhasil diajukan!');
    }

    public function edit(Peminjaman $peminjaman)
    {
        $books = Book::all();
        $members = Member::all();
        return view('peminjamans.form', compact('peminjaman', 'books', 'members'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'book_id'   => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'due_date'  => 'required|date|after:today',
            'notes'     => 'nullable|string',
        ]);

        $peminjaman->update($request->all());
        return redirect()->route('peminjamans.index')->with('success', 'Peminjaman berhasil diperbarui!');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        if ($peminjaman->status === 'approved') {
            $peminjaman->book->increment('available_copies'); // Kembalikan stok jika dihapus
        }
        $peminjaman->delete();
        return redirect()->route('peminjamans.index')->with('success', 'Peminjaman berhasil dihapus!');
    }

    public function approve(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'requested') {
            return redirect()->back()->withErrors(['status' => 'Hanya peminjaman requested yang bisa diapprove']);
        }

        $peminjaman->update([
            'status' => 'approved',
            'borrowed_at' => now(),
            'approved_by' => Auth::id(), // Asumsi user login sebagai approver
        ]);

        return redirect()->route('peminjamans.index')->with('success', 'Peminjaman berhasil diapprove!');
    }

    public function returnBook(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'approved') {
            return redirect()->back()->withErrors(['status' => 'Hanya peminjaman approved yang bisa dikembalikan']);
        }

        $peminjaman->update([
            'status' => 'returned',
            'returned_at' => now(),
        ]);

        $peminjaman->book->increment('available_copies');

        return redirect()->route('peminjamans.index')->with('success', 'Buku berhasil dikembalikan!');
    }
}