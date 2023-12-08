<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\EventController;

Route::get('/', [EventController::class, 'index']);
Route::get('/eventos/{id}', [EventController::class, 'show']);
Route::get('/eventos', [EventController::class, 'create'])->middleware('auth');
Route::get('/dashboard', [EventController::class, 'dashboard'])->middleware('auth');
Route::get('/eventos/{id}/editar', [EventController::class, 'edit'])->middleware('auth');
Route::post('/eventos', [EventController::class, 'store'])->middleware('auth');
Route::post('/eventos/{id}/entrar', [EventController::class, 'join'])->middleware('auth');
Route::put('/eventos/{id}', [EventController::class, 'update'])->middleware('auth');
Route::delete('/eventos/{id}', [EventController::class, 'destroy'])->middleware('auth');
Route::delete('/eventos/{id}/sair', [EventController::class, 'leave'])->middleware('auth');

// EXAMPLES
Route::get('/contato', function () {
    $search = request('search');

    return view('contact', ['search' => $search]);
});
Route::get('/produtos/{id?}', function ($id = null) {
    return view('contact', ['id' => $id]);
});
