<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitExportController;




Route::get('/', function () {
    //return view('welcome');
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.authenticate');


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::middleware('auth',)->group(function () {

    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ])->name('dashboard');

});


/*
|--------------------------------------------------------------------------
| Visits
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:admin,sales'
])->group(function () {

    Route::resource(
        'visits',
        VisitController::class
    );

});


Route::middleware(['auth', 'role:admin,sales'])->group(function () {

    Route::resource('visits', VisitController::class);

    Route::resource(
        'institutions',
        InstitutionController::class
    );
});

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::resource(
        'users',
        UserController::class
    );

    Route::post(
        'users/{user}/reset-password',
        [UserController::class, 'resetPassword']
    )->name('users.reset-password');

    Route::patch(
        'users/{user}/toggle-status',
        [UserController::class, 'toggleStatus']
    )->name('users.toggle-status');

});


Route::middleware(['auth', 'role:admin,sales'])->group(function () {

    Route::get(
        'visits/export/excel',
        [VisitExportController::class, 'excel']
    )->name('visits.export.excel');

    Route::get(
        'visits/export/pdf',
        [VisitExportController::class, 'pdf']
    )->name('visits.export.pdf');

    Route::resource(
        'visits',
        VisitController::class
    );
});


