<?php

use App\Http\Controllers\MovieController as PublicMovieController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\SheetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/movies', [PublicMovieController::class, 'index'])->name('movies.index');

Route::get('/sheets', [SheetController::class, 'index'])->name('sheets.index');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('movies')->name('movies.')->group(function () {
        Route::get('/', [MovieController::class, 'index'])->name('index');
        Route::get('/create', [MovieController::class, 'create'])->name('create');
        Route::post('/store', [MovieController::class, 'store'])->name('store'); // admin.movies.store
        Route::get('/{movie}/edit', [MovieController::class, 'edit'])->name('edit'); // admin.movies.edit
        Route::patch('/{movie}/update', [MovieController::class, 'update'])->name('update'); // admin.movies.update
        Route::delete('/{movie}/destroy', [MovieController::class, 'destroy'])->name('destroy'); // admin.movies.destroy
    });
});
