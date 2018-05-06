<?php

namespace App\Http\Controllers\Api;

use App\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookFavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth:api');
    }

    public function update(Book $book)
    {
        $book->update(['favorite'=> true]);
        return response()->json([
            'message' => 'Book favorited.',
            'book' => $book
        ]);
    }

    public function destroy(Book $book)
    {
        $book->update(['favorite', false]);
        return response()->json([
            'message' => 'Book unfavorited.',
            'book' => $book
        ]);
    }
}
