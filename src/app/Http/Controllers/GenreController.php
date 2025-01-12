<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class GenreController extends Controller
{
    // Display a list of all genres
    public function list(): View
    {
        $genres = Genre::orderBy('name', 'asc')->get();
        return view('genre.list', [
            'title' => 'Genres',
            'genres' => $genres,
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

    // Save a new genre
    public function put(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:genres,name',
        ]);

        Genre::create($validated);

        return redirect('/genres')->with('success', 'Genre created successfully!');
    }

    // Show form to edit an existing genre
    public function edit(Genre $genre): View
    {
        return view('genre.form', [
            'title' => 'Edit Genre',
            'genre' => $genre,
        ]);
    }

    // Update an existing genre
    public function patch(Request $request, Genre $genre): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:genres,name,' . $genre->id,
        ]);

        $genre->update($validated);

        return redirect('/genres')->with('success', 'Genre updated successfully!');
    }

    // Delete a genre
    public function delete(Genre $genre): RedirectResponse
    {
        $genre->delete();

        return redirect('/genres')->with('success', 'Genre deleted successfully!');
    }
}
