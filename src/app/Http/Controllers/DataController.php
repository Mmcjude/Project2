<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\JsonResponse;

class DataController extends Controller
{
    /**
     * Return 5 published books in random order.
     *
     * @return JsonResponse
     */
    public function getTopBooks(): JsonResponse
    {
        // Fetch 5 random books that are published and have 'display' as true
        $books = Book::with(['author', 'genre']) // Eager load the author and genre relationships
            ->where('display', true)
            ->inRandomOrder()
            ->take(5)  // Fetch 5 books instead of 3
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
        // Fetch the selected book that is published
        $selectedBook = Book::with(['author', 'genre']) // Eager load the author and genre relationships
            ->where([
                'id' => $book->id,
                'display' => true,
            ])
            ->firstOrFail(); // If not found, it will throw a 404 error

        return response()->json($selectedBook);
    }

    /**
     * Return 5 published books in random order, excluding the selected book.
     *
     * @param Book $book
     * @return JsonResponse
     */
    public function getRelatedBooks(Book $book): JsonResponse
    {
        // Fetch 5 random books that are published and excluding the selected book
        $books = Book::with(['author', 'genre']) // Eager load the author and genre relationships
            ->where('display', true)
            ->where('id', '<>', $book->id) // Exclude the selected book
            ->inRandomOrder()
            ->take(5)  // Fetch 5 books instead of 3
            ->get();

        return response()->json($books);
    }
}
