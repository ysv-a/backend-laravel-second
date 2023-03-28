<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpenApi\BookController;
use App\Http\Controllers\OpenApi\FileController;

Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::post('/books', [BookController::class, 'store']);
Route::put('/books/{id}', [BookController::class, 'update']);
Route::delete('/books/{id}', [BookController::class, 'delete']);

Route::post('/upload', [FileController::class, 'upload']);
