<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Routing\Controllers\HasMiddleware;

class AuthorController extends Controller implements HasMiddleware
{
    /**
     * Middleware assigned to the controller.
     */
    public static function middleware(): array
    {
        return ['auth'];
    }

    // List all authors
    public function list(): View
    {
        $items = Author::orderBy('name', 'asc')->get();

        return view('author.list', [
            'title' => 'Authors',
            'items' => $items,
        ]);
    }

    // Show create form
    public function create(): View
    {
        return view('author.form', [
            'title' => 'Add new author',
            'author' => new Author(), // Empty model for form binding
        ]);
    }

    // Store a new author
    public function put(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Author::create($validated);

        return redirect('/authors')->with('success', 'Author created successfully!');
    }

    // Show edit form
    public function edit(Author $author): View
    {
        return view('author.form', [
            'title' => 'Edit Author',
            'author' => $author,
        ]);
    }

    // Update existing author
    public function patch(Author $author, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $author->update($validated);

        return redirect('/authors')->with('success', 'Author updated successfully!');
    }

    // Delete an author
    public function delete(Author $author): RedirectResponse
    {
        $author->delete();

        return redirect('/authors')->with('success', 'Author deleted successfully!');
    }
}
