<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class BookController extends Controller
{
    public function index()
    {
        return response()->json(Book::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'author'         => 'required|string|max:255',
            'isbn'           => 'required|string|max:255|unique:books',
            'published_year' => 'nullable|digits:4|integer',
            'total_copies'   => 'required|integer|min:1',
        ]);

        $request['available_copies'] = $request->total_copies;

        $book = Book::create($request->all());
        return response()->json($book, 201);
    }
}