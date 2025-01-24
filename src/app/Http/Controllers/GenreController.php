<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

class GenreController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['auth'];
    }

    public function list(): View
    {
        $genres = Genre::orderBy('name', 'asc')->get();

        return view('genre.list', [
            'title' => 'Genres',
            'items' => $genres,
        ]);
    }

    public function create(): View
    {
        return view('genre.form', [
            'title' => 'Add New Genre',
            'genre' => new Genre(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateGenreData($request);
        Genre::create($validated);

        return redirect('/genres')->with('success', 'Genre created successfully!');
    }

    public function update(Genre $genre): View
    {
        return view('genre.form', [
            'title' => 'Edit Genre',
            'genre' => $genre,
        ]);
    }

    public function patch(Request $request, Genre $genre): RedirectResponse
    {
        $validated = $this->validateGenreData($request);
        $genre->update($validated);

        return redirect('/genres')->with('success', 'Genre updated successfully!');
    }

    public function delete(Genre $genre): RedirectResponse
    {
        $genre->delete();
        return redirect('/genres')->with('success', 'Genre deleted successfully!');
    }

    private function validateGenreData(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255|unique:genres,name,' . ($request->route('genre') ? $request->route('genre')->id : ''),
        ]);
    }
}
