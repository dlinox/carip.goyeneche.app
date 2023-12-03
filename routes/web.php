<?php

use App\Http\Controllers\Administrator\SpecialtyController;
use App\Http\Controllers\Administrator\AdministratorController;
use App\Http\Controllers\Administrator\AnnouncementsController;
use App\Http\Controllers\Administrator\AreaController;
use App\Http\Controllers\Administrator\CircuitController;
use App\Http\Controllers\Administrator\EventsAndCampaignsController;
use App\Http\Controllers\Administrator\FinalServiceController;
use App\Http\Controllers\Administrator\InstitutionalController;
use App\Http\Controllers\Administrator\IntermediateServiceController;
use App\Http\Controllers\Administrator\NewsController;
use App\Http\Controllers\Administrator\ObjetiveController;
use App\Http\Controllers\Administrator\OfficeController;
use App\Http\Controllers\Administrator\PublicationController;
use App\Http\Controllers\Administrator\PurchaseAndServiceController;
use App\Http\Controllers\Administrator\ServicePortfolioController;
use App\Http\Controllers\Administrator\SliderController;
use App\Http\Controllers\Administrator\SupportingServicesController;
use App\Http\Controllers\Administrator\UserController;
use App\Http\Controllers\Administrator\WorkerController;
use App\Http\Controllers\Auth\AuthController;
use App\Models\PublicationDocument;
use Illuminate\Support\Facades\Mail;
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

    //Rutas para el recupero de contraseña
    Route::get('/forgot-password',  [AuthController::class, 'forgotPassword'])->middleware('guest')->name('password.request');
    Route::post('/forgot-password',  [AuthController::class, 'sendPasswordResetLink'])->middleware('guest')->name('password.email');

    Route::get('/reset-password/{token}',  [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.reset');
    Route::post('/reset-password',  [AuthController::class, 'updatePassword'])->middleware('guest')->name('password.update');
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

    Route::resource('announcements', AnnouncementsController::class);
    Route::patch('announcements/{id}/change-state',  [AnnouncementsController::class, 'changeState']);
    
    Route::delete('announcements/{id}/documents/{document}',  [AnnouncementsController::class, 'documentsDestroy']);
    

    Route::resource('areas', AreaController::class);

    //Purchase and service
    Route::resource('purchase-and-service',  PurchaseAndServiceController::class);
    Route::patch('purchase-and-service/{id}/change-state',  [PurchaseAndServiceController::class, 'changeState']);

    // Route::get('purchase-and-service',  function () {
    //     return Inertia::render('admin/purchaseAndService/index');
    // });
    //news
    Route::resource('news', NewsController::class);
    Route::patch('news/{id}/change-state',  [NewsController::class, 'changeState']);
    Route::patch('news/{id}/change-featured', [NewsController::class, 'changeFeatured']);

    Route::resource('events-and-campaigns', EventsAndCampaignsController::class);
    Route::patch('events-and-campaigns/{id}/change-state',  [EventsAndCampaignsController::class, 'changeState']);
    Route::patch('events-and-campaigns/{id}/change-featured', [EventsAndCampaignsController::class, 'changeFeatured']);

    //publications
    Route::resource('publications',  PublicationController::class);
    Route::patch('publications/{id}/change-state',  [PublicationController::class, 'changeState']);
    Route::delete('publications/{id}/documents/{document}',  [PublicationController::class, 'documentsDestroy']);
    
    
    Route::resource('sliders', SliderController::class);
    Route::patch('sliders/{id}/change-state',  [SliderController::class, 'changeState']);

    Route::get('notifications',  function () {
        return Inertia::render('admin/notifications/index');
    });
});

// test para elvial el mail ResetPasswordEmail
// Route::get('/test-email', function () {
//     Mail::to('nearlino20@gmail.com')->send(new ResetPasswordEmail());
//     echo 'enviando correo';
// });

//Rutas para el recupero de contraseña

//Route::get('/forgot-password',  [AuthController::class, 'forgotPassword'])->middleware('guest')->name('password.request');
//Route::post('/forgot-password',  [AuthController::class, 'sendPasswordResetLink'])->middleware('guest')->name('password.email');
//Route::get('/reset-password/{token}',  [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.reset');
//Route::post('/reset-password',  [AuthController::class, 'updatePassword'])->middleware('guest')->name('password.update');
