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

// Book routes
Route::get('/books', [BookController::class, 'list']);
Route::get('/books/create', [BookController::class, 'create']);
Route::post('/books/put', [BookController::class, 'put']);
Route::get('/books/edit/{book}', [BookController::class, 'edit']); // Added edit route
Route::patch('/books/patch/{book}', [BookController::class, 'update']); // Changed to patch
Route::delete('/books/delete/{book}', [BookController::class, 'delete']); // Changed to delete

// Genre routes
Route::get('/genres', [GenreController::class, 'list']);
Route::get('/genres/create', [GenreController::class, 'create']);
Route::post('/genres/put', [GenreController::class, 'put']);
Route::get('/genres/edit/{genre}', [GenreController::class, 'edit']);
Route::patch('/genres/patch/{genre}', [GenreController::class, 'patch']);
Route::delete('/genres/delete/{genre}', [GenreController::class, 'delete']);
