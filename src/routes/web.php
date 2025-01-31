<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\DataController;

// -----------------------
// Home Route
// -----------------------
Route::get('/', [HomeController::class, 'index']);



// Author Routes
Route::get('/authors', [AuthorController::class, 'list']);
Route::get('/authors/create', [AuthorController::class, 'create']);
Route::post('/authors', [AuthorController::class, 'put']); 
Route::get('/authors/update/{author}', [AuthorController::class, 'edit']);
Route::patch('/authors/{author}', [AuthorController::class, 'patch']); 
Route::delete('/authors/{author}', [AuthorController::class, 'delete']);

// -----------------------
// Auth Routes
// -----------------------
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth', [AuthController::class, 'authenticate']);
Route::get('/logout', [AuthController::class, 'logout']);

// -----------------------
// Book Routes (protected by middleware in controller)
// -----------------------
Route::get('/books', [BookController::class, 'list']);
Route::get('/books/create', [BookController::class, 'create']);
Route::post('/books', [BookController::class, 'store']);
Route::put('/books/{book}', [BookController::class, 'put']); 
Route::get('/books/update/{book}', [BookController::class, 'update']);
Route::patch('/books/{book}', [BookController::class, 'patch']);
Route::delete('/books/{book}', [BookController::class, 'delete']);

// -----------------------
// Genre Routes (protected by middleware in controller)
// -----------------------
Route::get('/genres', [GenreController::class, 'list']);
Route::get('/genres/create', [GenreController::class, 'create']);
Route::post('/genres', [GenreController::class, 'store']);
Route::get('/genres/edit/{genre}', [GenreController::class, 'update']);
Route::patch('/genres/{genre}', [GenreController::class, 'patch']);
Route::delete('/genres/{genre}', [GenreController::class, 'delete']);

// -----------------------
// Data/API Routes (public access)
// -----------------------
Route::get('/data/get-top-books', [DataController::class, 'getTopBooks']);
Route::get('/data/get-book/{book}', [DataController::class, 'getBook']);
Route::get('/data/get-related-books/{book}', [DataController::class, 'getRelatedBooks']);
