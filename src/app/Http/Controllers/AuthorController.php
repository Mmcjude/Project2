<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Routing\Controllers\HasMiddleware;

class AuthorController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['auth'];
    }

    public function list(): View
    {
        $authors = Author::orderBy('name', 'asc')->get();

        return view('author.list', [
            'title' => 'Authors',
            'items' => $authors,
        ]);
    }

    public function create(): View
    {
        return view('author.form', [
            'title' => 'Add New Author',
            'author' => new Author(),
        ]);
    }

    public function put(Request $request): RedirectResponse
    {
        $validated = $this->validateAuthorData($request);
        Author::create($validated);

        return redirect('/authors')->with('success', 'Author created successfully!');
    }

    public function edit(Author $author): View
    {
        return view('author.form', [
            'title' => 'Edit Author',
            'author' => $author,
        ]);
    }

    public function patch(Request $request, Author $author): RedirectResponse
    {
        $validated = $this->validateAuthorData($request);
        $author->update($validated);

        return redirect('/authors')->with('success', 'Author updated successfully!');
    }

    public function delete(Author $author): RedirectResponse
    {
        $author->delete();
        return redirect('/authors')->with('success', 'Author deleted successfully!');
    }

    private function validateAuthorData(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255|unique:authors,name,' . ($request->route('author') ? $request->route('author')->id : ''),
        ]);
    }
}
