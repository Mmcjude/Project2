<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\View\View;

class DataController extends Controller
{
    /**
     * Return 3 published books in random order and display them.
     *
     * @return View
     */
    public function getTopBooks(): View
    {
        $books = Book::with(['author', 'genre']) // Eager load the author and genre relationships
            ->where('display', true)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('public', ['books' => $books]);
    }

    /**
     * Return the selected book if it's published.
     *
     * @param Book $book
     * @return View
     */
    public function getBook(Book $book): View
    {
        $selectedBook = Book::with(['author', 'genre']) // Eager load the author and genre relationships
            ->where([
                'id' => $book->id,
                'display' => true,
            ])
            ->firstOrFail();

        return view('book-detail', ['book' => $selectedBook]);
    }

    /**
     * Return 3 related published books, excluding the selected book.
     *
     * @param Book $book
     * @return View
     */
    public function getRelatedBooks(Book $book): View
    {
        $books = Book::with(['author', 'genre']) // Eager load the author and genre relationships
            ->where('display', true)
            ->where('id', '<>', $book->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('related-books', ['books' => $books]);
    }
}
