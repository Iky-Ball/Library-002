<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'librarian'])) {
            abort(403, 'Anda tidak memiliki izin untuk menambahkan buku.');
        }

        return view('books.form');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'librarian'])) {
            abort(403, 'Anda tidak memiliki izin untuk menambahkan buku.');
        }

        $request->validate([
            'title'          => 'required|string|max:255',
            'author'         => 'required|string|max:255',
            'isbn'           => 'required|string|max:255|unique:books',
            'published_year' => 'nullable|digits:4|integer',
            'total_copies'   => 'required|integer|min:1',
        ]);

        $book = Book::create([
            'title'           => $request->title,
            'author'          => $request->author,
            'isbn'            => $request->isbn,
            'published_year'  => $request->published_year,
            'total_copies'    => $request->total_copies,
            'available_copies'=> $request->total_copies,
        ]);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit(Book $book)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'librarian'])) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit buku.');
        }

        return view('books.form', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'librarian'])) {
            abort(403, 'Anda tidak memiliki izin untuk memperbarui buku.');
        }

        $request->validate([
            'title'          => 'required|string|max:255',
            'author'         => 'required|string|max:255',
            'isbn'           => 'required|string|max:255|unique:books,isbn,' . $book->id,
            'published_year' => 'nullable|digits:4|integer',
            'total_copies'   => 'required|integer|min:1',
        ]);

        // Update stok available_copies jika total_copies berubah
        $difference = $request->total_copies - $book->total_copies;
        $book->available_copies += $difference;

        $book->update([
            'title'           => $request->title,
            'author'          => $request->author,
            'isbn'            => $request->isbn,
            'published_year'  => $request->published_year,
            'total_copies'    => $request->total_copies,
            'available_copies'=> max($book->available_copies, 0),
        ]);

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy(Book $book)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'librarian'])) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus buku.');
        }

        $book->delete();
        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus!');
    }
}
