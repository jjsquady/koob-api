<?php

namespace App\Http\Controllers\Api;

use App\Book;
use App\Filters\BookFilters;
use App\Http\Requests\BookFormRequest;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth:api');
    }

    public function index(BookFilters $filters)
    {
        return Book::filter($filters)->get();
    }

    public function store(BookFormRequest $request)
    {
        try {
            $book = Book::create($request->all());
            return response()->json([
                'message' => 'Book added successfully to user.',
                'book' => $book
            ]);
        }catch (\Exception $exception) {
            return response()->json([
                'error' => 'Failed to create a book resource.',
                'message' => $exception->getMessage()
            ], 400);
        }
    }
}
