<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;

// Home route
Route::get('/', [HomeController::class, 'index']);

// Author routes
Route::get('/authors', [AuthorController::class, 'list']);
Route::get('/authors/create', [AuthorController::class, 'create']);
Route::post('/authors/put', [AuthorController::class, 'put']);
Route::get('/authors/update/{author}', [AuthorController::class, 'edit']);
Route::post('/authors/patch/{author}', [AuthorController::class, 'patch']);
Route::post('/authors/delete/{author}', [AuthorController::class, 'delete']);

// Auth routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth', [AuthController::class, 'authenticate']);
Route::get('/logout', [AuthController::class, 'logout']);


// Routes for managing books

// Display all books
Route::get('/books', [BookController::class, 'list']);

// Show form to create a new book
Route::get('/books/create', [BookController::class, 'create']);

// Store a new book (POST)
Route::post('/books', [BookController::class, 'store']); // Changed from '/books/put'

// Show form to update an existing book
Route::get('/books/update/{book}', [BookController::class, 'update']);

// Apply changes to a book (PATCH)
Route::post('/books/patch/{book}', [BookController::class, 'patch']);

// Delete a book
Route::post('/books/delete/{book}', [BookController::class, 'delete']);



// Routes for managing genres

// Display all genres
Route::get('/genres', [GenreController::class, 'list']);

// Show form to create a new genre
Route::get('/genres/create', [GenreController::class, 'create']);

// Store a new genre (POST)
Route::post('/genres', [GenreController::class, 'store']); 

// Show form to update an existing genre
Route::get('/genres/edit/{genre}', [GenreController::class, 'update']);

// Apply changes to a genre (PATCH)
Route::post('/genres/patch/{genre}', [GenreController::class, 'patch']);

// Delete a genre
Route::post('/genres/delete/{genre}', [GenreController::class, 'delete']);
