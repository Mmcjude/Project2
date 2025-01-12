<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

class BookController extends Controller implements HasMiddleware
{
    // Call auth middleware
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    // Display all books
    public function list(): View
    {
        $items = Book::orderBy('name', 'asc')->get();
        return view('book.list', [
            'title' => 'Books',
            'items' => $items,
        ]);
    }

    // Display new book form
    public function create(): View
    {
        $authors = Author::orderBy('name', 'asc')->get();
        $genres = Genre::orderBy('name', 'asc')->get();
        return view(
            'book.form',
            [
                'title' => 'Add new book',
                'book' => new Book(),
                'authors' => $authors,
                'genres' => $genres,
            ]
        );
    }

    // Save Book data (create/update)
    private function saveBookData(Book $book, BookRequest $request)
    {
        $validatedData = $request->validated();

        $book->fill($validatedData);
        $book->genre_id = $validatedData['genre_id'];
        $book->display = (bool) ($validatedData['display'] ?? false);

        if ($request->hasFile('image')) {
            // Handle image upload
            $uploadedFile = $request->file('image');
            $extension = $uploadedFile->clientExtension();
            $name = uniqid();
            $book->image = $uploadedFile->storePubliclyAs(
                '/',
                $name . '.' . $extension,
                'uploads'
            );
        }

        $book->save();
    }

    // Create a new book entry
    public function put(BookRequest $request): RedirectResponse
    {
        $book = new Book();
        $this->saveBookData($book, $request);
        return redirect('/books')->with('success', 'Book created successfully!');
    }

    // Update book data
    public function patch(Book $book, BookRequest $request): RedirectResponse
    {
        $this->saveBookData($book, $request);
        return redirect('/books')->with('success', 'Book updated successfully!');
    }

    // Display book edit form
    public function update(Book $book): View
    {
        $authors = Author::orderBy('name', 'asc')->get();
        $genres = Genre::orderBy('name', 'asc')->get();
        return view(
            'book.form',
            [
                'title' => 'Edit book',
                'book' => $book,
                'authors' => $authors,
                'genres' => $genres,
            ]
        );
    }

    // Delete a book
    public function delete(Book $book): RedirectResponse
    {
        if ($book->image && file_exists(storage_path('app/public/' . $book->image))) {
            unlink(storage_path('app/public/' . $book->image));
        }
        $book->delete();
        return redirect('/books')->with('success', 'Book deleted successfully!');
    }
}
