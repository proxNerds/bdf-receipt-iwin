<?php

use App\Http\Controllers\ParticipationController;
use App\Http\Controllers\ParticipationDrawController;
use App\Http\Controllers\SalesForceController;
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



// contest status
Route::get('/status/{id}', [ParticipationController::class, 'getContestStatus']);

Route::get('/', [ParticipationController::class, 'index'])->name('home');

Route::post('participate', [ParticipationController::class, 'participate']);
Route::post('participateDraw', [ParticipationDrawController::class, 'participate']);

/* SalesForce CheckUser */
Route::post('/sales-force/checkuser', [SalesForceController::class, 'checkUser']);
