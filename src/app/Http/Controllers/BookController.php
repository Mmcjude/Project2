<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BookController extends Controller
{
    // Display all books
    public function list(): View
    {
        $books = Book::with(['author', 'genre'])->orderBy('name', 'asc')->get();

        return view('book.list', [
            'title' => 'Books',
            'items' => $books,
        ]);
    }

    // Show form to create a new book
    public function create(): View
    {
        $authors = Author::orderBy('name', 'asc')->get();
        $genres = Genre::orderBy('name', 'asc')->get();

        return view('book.form', [
            'title' => 'Add New Book',
            'book' => new Book(),
            'authors' => $authors,
            'genres' => $genres,
        ]);
    }

    // Store a new book (POST)
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateBookData($request);

        // If the image is uploaded, store it and add the path to the validated data
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        // Ensure display is set to false if not provided
        $validated['display'] = $validated['display'] ?? false;

        // Create the new book record
        Book::create($validated);

        return redirect('/books')->with('success', 'Book created successfully!');
    }

    // Show form to update a book
    public function update(Book $book): View
    {
        $authors = Author::orderBy('name', 'asc')->get();
        $genres = Genre::orderBy('name', 'asc')->get();

        return view('book.form', [
            'title' => 'Edit Book',
            'book' => $book,
            'authors' => $authors,
            'genres' => $genres,
        ]);
    }

    // Apply changes to the book (PATCH)
    public function patch(Request $request, Book $book): RedirectResponse
    {
        $validated = $this->validateBookData($request, $book);

        // If the image is uploaded, store it and add the path to the validated data
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        // Ensure display is set to false if not provided
        $validated['display'] = $validated['display'] ?? false;

        // Update the book record
        $book->update($validated);

        return redirect('/books')->with('success', 'Book updated successfully!');
    }

    // Delete a book
    public function delete(Book $book): RedirectResponse
    {
        // Delete image if exists
        if ($book->image && file_exists(storage_path('app/public/' . $book->image))) {
            unlink(storage_path('app/public/' . $book->image));
        }

        $book->delete();

        return redirect('/books')->with('success', 'Book deleted successfully!');
    }

    // Private method for validation rules
    private function validateBookData(Request $request, Book $book = null): array
    {
        // Here, we validate the incoming data
        return $request->validate([
            'name' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genre_id' => 'nullable|exists:genres,id',
            'description' => 'nullable|string',
            'year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'display' => 'nullable|boolean',
        ]);
    }
}
