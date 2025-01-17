<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\JsonResponse;

class DataController extends Controller
{
    /**
     * Return 3 published books in random order.
     *
     * @return JsonResponse
     */
    public function getTopBooks(): JsonResponse
    {
        $books = Book::with(['author', 'genre']) // Eager load the author and genre relationships
            ->where('display', true)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return response()->json($books);
    }

    /**
     * Return the selected book if it's published.
     *
     * @param Book $book
     * @return JsonResponse
     */
    public function getBook(Book $book): JsonResponse
    {
        $selectedBook = Book::with(['author', 'genre']) // Eager load the author and genre relationships
            ->where([
                'id' => $book->id,
                'display' => true,
            ])
            ->firstOrFail();

        return response()->json($selectedBook);
    }

    /**
     * Return 3 published books in random order, excluding the selected book.
     *
     * @param Book $book
     * @return JsonResponse
     */
    public function getRelatedBooks(Book $book): JsonResponse
    {
        $books = Book::with(['author', 'genre']) // Eager load the author and genre relationships
            ->where('display', true)
            ->where('id', '<>', $book->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return response()->json($books);
    }
}
