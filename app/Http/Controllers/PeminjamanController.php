<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (in_array($user->role, ['admin', 'librarian'])) {
            $peminjamans = Peminjaman::with(['book', 'member', 'approver'])->get();
        } else {
            $member = Member::where('user_id', $user->id)->first();
            if (!$member) {
                return redirect()->back()->withErrors(['member' => 'Data anggota tidak ditemukan.']);
            }
            $peminjamans = Peminjaman::with(['book', 'member', 'approver'])
                ->where('member_id', $member->id)
                ->get();
        }

        return view('peminjamans.index', compact('peminjamans'));
    }

    public function create()
    {
        $user = Auth::user();

        if (in_array($user->role, ['admin', 'librarian'])) {
            $books = Book::where('available_copies', '>', 0)->get();
            $members = Member::all();
        } else {
            $books = Book::where('available_copies', '>', 0)->get();
            $members = Member::where('user_id', $user->id)->get();
        }

        return view('peminjamans.form', compact('books', 'members'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'book_id'   => 'required|exists:books,id',
            'due_date'  => 'required|date|after:today',
            'notes'     => 'nullable|string',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->available_copies <= 0) {
            return redirect()->back()->withErrors(['book_id' => 'Buku tidak tersedia']);
        }

        if (in_array($user->role, ['admin', 'librarian'])) {
            $request->validate(['member_id' => 'required|exists:members,id']);
            $memberId = $request->member_id;
        } else {
            $member = Member::where('user_id', $user->id)->first();
            if (!$member) {
                return redirect()->back()->withErrors(['member' => 'Data anggota tidak ditemukan.']);
            }
            $memberId = $member->id;
        }

        $book->decrement('available_copies');

        Peminjaman::create([
            'book_id'     => $request->book_id,
            'member_id'   => $memberId,
            'due_date'    => $request->due_date,
            'status'      => Peminjaman::STATUS_REQUESTED,
            'notes'       => $request->notes,
        ]);

        return redirect()->route('peminjamans.index')->with('success', 'Peminjaman berhasil diajukan!');
    }

    public function edit(Peminjaman $peminjaman)
    {
        $user = Auth::user();

        if ($user->role === 'member' && $peminjaman->member->user_id !== $user->id) {
            abort(403, 'Anda tidak boleh mengedit peminjaman orang lain.');
        }

        $books = Book::all();
        $members = Member::all();
        return view('peminjamans.form', compact('peminjaman', 'books', 'members'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $user = Auth::user();

        if ($user->role === 'member' && $peminjaman->member->user_id !== $user->id) {
            abort(403, 'Anda tidak boleh mengupdate peminjaman orang lain.');
        }

        $request->validate([
            'book_id'   => 'required|exists:books,id',
            'due_date'  => 'required|date|after:today',
            'notes'     => 'nullable|string',
        ]);

        $peminjaman->update([
            'book_id'   => $request->book_id,
            'due_date'  => $request->due_date,
            'notes'     => $request->notes,
        ]);

        return redirect()->route('peminjamans.index')->with('success', 'Peminjaman berhasil diperbarui!');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $user = Auth::user();

        if ($user->role === 'member' && $peminjaman->member->user_id !== $user->id) {
            abort(403, 'Anda tidak boleh menghapus peminjaman orang lain.');
        }

        if ($peminjaman->status === Peminjaman::STATUS_APPROVED) {
            $peminjaman->book->increment('available_copies');
        }

        $peminjaman->delete();
        return redirect()->route('peminjamans.index')->with('success', 'Peminjaman berhasil dihapus!');
    }

    public function approve(Peminjaman $peminjaman)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['admin', 'librarian'])) {
            abort(403, 'Hanya admin/librarian yang bisa approve.');
        }

        if ($peminjaman->status !== Peminjaman::STATUS_REQUESTED) {
            return redirect()->back()->withErrors(['status' => 'Hanya peminjaman requested yang bisa diapprove']);
        }

        $peminjaman->update([
            'status'      => Peminjaman::STATUS_APPROVED,
            'borrowed_at' => now(),
            'approved_by' => $user->id,
        ]);

        return redirect()->route('peminjamans.index')->with('success', 'Peminjaman berhasil diapprove!');
    }

    public function reject(Peminjaman $peminjaman)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['admin', 'librarian'])) {
            abort(403, 'Hanya admin/librarian yang bisa reject.');
        }

        if ($peminjaman->status !== Peminjaman::STATUS_REQUESTED) {
            return redirect()->back()->withErrors(['status' => 'Hanya peminjaman requested yang bisa direject']);
        }

        $peminjaman->update([
            'status'      => Peminjaman::STATUS_REJECTED,
            'approved_by' => $user->id,
        ]);

        $peminjaman->book->increment('available_copies');

        return redirect()->route('peminjamans.index')->with('success', 'Peminjaman berhasil ditolak!');
    }

    public function returnBook(Peminjaman $peminjaman)
    {
        $user = Auth::user();

        if ($peminjaman->status !== Peminjaman::STATUS_APPROVED) {
            return redirect()->back()->withErrors(['status' => 'Hanya peminjaman approved yang bisa dikembalikan']);
        }

        if ($user->role === 'member' && $peminjaman->member->user_id !== $user->id) {
            abort(403, 'Anda tidak boleh mengembalikan peminjaman orang lain.');
        }

        $peminjaman->update([
            'status'      => Peminjaman::STATUS_RETURNED,
            'returned_at' => now(),
        ]);

        $peminjaman->book->increment('available_copies');

        return redirect()->route('peminjamans.index')->with('success', 'Buku berhasil dikembalikan!');
    }
}
