<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BloqueController;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Auth::routes();


Route::resource('bloques', BloqueController::class);




use App\Http\Controllers\EventoController;

Route::get('/calendar', [EventoController::class, 'showCalendar']);

// Rutas para el controlador EventoController
Route::get('/eventos', [EventoController::class, 'index'])->name('eventos.index');
Route::get('/eventos/create', [EventoController::class, 'create'])->name('eventos.create');
Route::post('/eventos', [EventoController::class, 'store'])->name('eventos.store');

Route::get('/get-bloques', [BloqueController::class, 'getBloques']);

Route::put('/update-bloque/{bloque}', [BloqueController::class, 'update']);

Route::delete('/delete-bloque/{bloque}', [BloqueController::class, 'destroy']);
