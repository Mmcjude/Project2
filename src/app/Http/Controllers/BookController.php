<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use App\Http\Requests\BookRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Routing\Controllers\HasMiddleware;

class BookController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['auth'];
    }

    public function list(): View
    {
        $items = Book::orderBy('name', 'asc')->get();
        return view('book.list', [
            'title' => 'Books',
            'items' => $items,
        ]);
    }

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

    private function saveBookData(Book $book, BookRequest $request)
    {
        $validatedData = $request->validated();
        $book->fill($validatedData);
        $book->genre_id = $validatedData['genre_id'];
        $book->display = (bool) ($validatedData['display'] ?? false);

        if ($request->hasFile('image')) {
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

    public function store(BookRequest $request): RedirectResponse
    {
        $book = new Book();
        $this->saveBookData($book, $request);
        return redirect('/books')->with('success', 'Book created successfully!');
    }

    public function put(BookRequest $request, Book $book): RedirectResponse
    {
        $this->saveBookData($book, $request);
        return redirect('/books')->with('success', 'Book updated successfully!');
    }

    public function patch(BookRequest $request, Book $book): RedirectResponse
    {
        $this->saveBookData($book, $request);
        return redirect('/books')->with('success', 'Book updated successfully!');
    }

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

    public function delete(Book $book): RedirectResponse
    {
        if ($book->image && file_exists(storage_path('app/public/' . $book->image))) {
            unlink(storage_path('app/public/' . $book->image));
        }
        $book->delete();
        return redirect('/books')->with('success', 'Book deleted successfully!');
    }
}
