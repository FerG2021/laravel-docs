<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClientController;


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

Route::get('/clientes', [ClientController::class, 'index']);
Route::post('/clientes', [ClientController::class, 'create']);
Route::get('/clientes/{id}', [ClientController::class, 'show']);
Route::put('/clientes/{id}', [ClientController::class, 'edit']);
Route::delete('/clientes/{id}', [ClientController::class, 'destroy']);


Route::get('/', function () {
    return view('welcome');
});
