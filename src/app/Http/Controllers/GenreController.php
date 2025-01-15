<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class GenreController extends Controller
{
    // Display all genres
    public function list(): View
    {
        $genres = Genre::orderBy('name', 'asc')->get();

        return view('genre.list', [
            'title' => 'Genres',
            'items' => $genres,
        ]);
    }

    // Show form to create a new genre
    public function create(): View
    {
        return view('genre.form', [
            'title' => 'Add New Genre',
            'genre' => new Genre(),
        ]);
    }

    // Store a new genre (POST)
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateGenreData($request);

        Genre::create($validated);

        return redirect('/genres')->with('success', 'Genre created successfully!');
    }

    // Show form to update a genre
    public function update(Genre $genre): View
    {
        return view('genre.form', [
            'title' => 'Edit Genre',
            'genre' => $genre,
        ]);
    }

    // Apply changes to the genre (PATCH)
    public function patch(Request $request, Genre $genre): RedirectResponse
    {
        $validated = $this->validateGenreData($request);

        $genre->update($validated);

        return redirect('/genres')->with('success', 'Genre updated successfully!');
    }

    // Delete a genre
    public function delete(Genre $genre): RedirectResponse
    {
        $genre->delete();

        return redirect('/genres')->with('success', 'Genre deleted successfully!');
    }

    // Private method for validation rules
    private function validateGenreData(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255|unique:genres,name,' . ($request->route('genre') ? $request->route('genre')->id : ''),
        ]);
    }
}
