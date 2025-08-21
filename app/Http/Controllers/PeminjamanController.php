<?php

namespace App\Http\Controllers;


use App\Models\Peminjaman;
use App\Models\Book;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        return response()->json(
            Peminjaman::with(['book', 'member', 'approver'])->get()
        );
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
            return response()->json(['message' => 'Buku tidak tersedia'], 400);
        }

        // Kurangi stok buku
        $book->decrement('available_copies');

        $peminjaman = Peminjaman::create([
            'book_id'     => $request->book_id,
            'member_id'   => $request->member_id,
            'due_date'    => $request->due_date,
            'status'      => 'requested',
            'notes'       => $request->notes,
        ]);

        return response()->json($peminjaman, 201);
    }
}