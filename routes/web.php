<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;

Route::get('/', function () {
    return redirect()->route('book.index');
});

Route::resource('book', BookController::class)
->only(['index', 'show']);

Route::resource('book.reviews', ReviewController::class)
->scoped(['review' => 'book'])
->only(['create', 'store']);


Route::get('/books', function () {
    dd(request('filter'));
})->name('book.dd');
