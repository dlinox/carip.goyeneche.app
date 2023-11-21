<?php

use App\Http\Controllers\Administrator\AdministratorController;
use App\Http\Controllers\Administrator\CircuitController;
use App\Http\Controllers\Administrator\InstitutionalController;
use App\Http\Controllers\Administrator\UserController;
use App\Http\Controllers\Administrator\WorkerController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('home');
});



Route::name('auth.')->prefix('auth')->group(function () {
    Route::get('/login',  [AuthController::class, 'index'])->name('login')->middleware('guest');
    Route::post('/sign-in',  [AuthController::class, 'signIn'])->name('sign-in')->middleware('guest');
});


Route::middleware(['auth'])->name('a.')->prefix('a')->group(function () {
    Route::get('',  [AdministratorController::class, 'index']);

    Route::resource('users', UserController::class);
    Route::resource('workers', WorkerController::class);
    
    Route::post('workers/authorities',  [WorkerController::class, 'authorities']);
    Route::delete('workers/authorities/{id}',  [WorkerController::class, 'authoritiesDestroy']);
    
    Route::resource('institutional', InstitutionalController::class);

    Route::resource('circuit', CircuitController::class);


});
