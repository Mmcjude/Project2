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



// -----------------------
// Author Routes
// -----------------------
Route::get('/authors', [AuthorController::class, 'list']);
Route::get('/authors/create', [AuthorController::class, 'create']);
Route::post('/authors/put', [AuthorController::class, 'put']);
Route::get('/authors/update/{author}', [AuthorController::class, 'edit']);
Route::patch('/authors/patch/{author}', [AuthorController::class, 'patch']);
Route::delete('/authors/delete/{author}', [AuthorController::class, 'delete']);

// -----------------------
// Authentication Routes
// -----------------------
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth', [AuthController::class, 'authenticate']);
Route::get('/logout', [AuthController::class, 'logout']);

// -----------------------
// Book Routes
// -----------------------
Route::get('/books', [BookController::class, 'list']);
Route::get('/books/create', [BookController::class, 'create']);
Route::post('/books', [BookController::class, 'store']);  // This uses store
Route::get('/books/update/{book}', [BookController::class, 'update']);
Route::patch('/books/patch/{book}', [BookController::class, 'patch']);
Route::delete('/books/delete/{book}', [BookController::class, 'delete']);


// -----------------------
// Genre Routes
// -----------------------
Route::get('/genres', [GenreController::class, 'list']);
Route::get('/genres/create', [GenreController::class, 'create']);
Route::post('/genres', [GenreController::class, 'store']);
Route::get('/genres/edit/{genre}', [GenreController::class, 'update']);
Route::patch('/genres/patch/{genre}', [GenreController::class, 'patch']);
Route::delete('/genres/delete/{genre}', [GenreController::class, 'delete']);


// -----------------------
// Data/API Routes
// -----------------------
Route::get('/data/get-top-books', [DataController::class, 'getTopBooks']);
Route::get('/data/get-book/{book}', [DataController::class, 'getBook']);
Route::get('/data/get-related-books/{book}', [DataController::class, 'getRelatedBooks']);




