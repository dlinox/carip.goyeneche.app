<?php

use App\Http\Controllers\Administrator\SpecialtyController;
use App\Http\Controllers\Administrator\AdministratorController;
use App\Http\Controllers\Administrator\AreaController;
use App\Http\Controllers\Administrator\CircuitController;
use App\Http\Controllers\Administrator\FinalServiceController;
use App\Http\Controllers\Administrator\InstitutionalController;
use App\Http\Controllers\Administrator\IntermediateServiceController;
use App\Http\Controllers\Administrator\ObjetiveController;
use App\Http\Controllers\Administrator\OfficeController;
use App\Http\Controllers\Administrator\ServicePortfolioController;
use App\Http\Controllers\Administrator\SupportingServicesController;
use App\Http\Controllers\Administrator\UserController;
use App\Http\Controllers\Administrator\WorkerController;
use App\Http\Controllers\Auth\AuthController;
use App\Models\IntermediateService;
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
    return Inertia::render('auth/login');
});



Route::name('auth.')->prefix('auth')->group(function () {
    Route::get('/login',  [AuthController::class, 'index'])->name('login')->middleware('guest');
    Route::post('/sign-in',  [AuthController::class, 'signIn'])->name('sign-in')->middleware('guest');
    Route::post('/sign-out',  [AuthController::class, 'signOut'])->name('sign-out')->middleware('auth');
});


Route::middleware(['auth'])->name('a.')->prefix('a')->group(function () {
    Route::get('',  [AdministratorController::class, 'index']);

    Route::resource('users', UserController::class);
    Route::patch('users/{id}/change-state',  [UserController::class, 'changeState']);

    Route::resource('workers', WorkerController::class);
    Route::patch('workers/{id}/change-state',  [WorkerController::class, 'changeState']);

    Route::post('workers/authorities',  [WorkerController::class, 'authorities']);
    Route::delete('workers/authorities/{id}',  [WorkerController::class, 'authoritiesDestroy']);

    Route::resource('institutional', InstitutionalController::class);

    Route::resource('circuit', CircuitController::class);
    Route::patch('circuit/{id}/change-state',  [CircuitController::class, 'changeState']);

    Route::resource('servicePortfolio', ServicePortfolioController::class);
    Route::patch('servicePortfolio/{id}/change-state',  [ServicePortfolioController::class, 'changeState']);

    Route::resource('supporting-services', SupportingServicesController::class);
    Route::patch('supporting-services/{id}/change-state',  [SupportingServicesController::class, 'changeState']);

    Route::resource('offices', OfficeController::class);
    Route::patch('offices/{id}/change-state',  [OfficeController::class, 'changeState']);

    Route::resource('intermediate-services',  IntermediateServiceController::class);
    Route::patch('intermediate-services/{id}/change-state',  [IntermediateServiceController::class, 'changeState']);


    Route::resource('final-services', FinalServiceController::class);
    Route::patch('final-services/{id}/change-state',  [FinalServiceController::class, 'changeState']);

    Route::resource('objetives', ObjetiveController::class);
    Route::patch('objetives/{id}/change-state',  [ObjetiveController::class, 'changeState']);

    Route::resource('specialties', SpecialtyController::class);

    Route::get('announcements',  function () {
        return Inertia::render('admin/announcement/index');
    });

    Route::resource('areas', AreaController::class);

    //Purchase and service
    Route::get('purchase-and-service',  function () {
        return Inertia::render('admin/purchaseAndService/index');
    });

    //news
    Route::get('news',  function () {
        return Inertia::render('admin/news/index');
    });

    //events and campaigns
    Route::get('events-and-campaigns',  function () {
        return Inertia::render('admin/eventsAndCampaigns/index');
    });
    

    
});
