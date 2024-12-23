<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GuestController;

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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/card-template', [HomeController::class, 'template']);
Route::get('/card-template/{guest}', [GuestController::class, 'show']);

Route::get('/card-confirm/{guest}/response', [HomeController::class, 'confirm']);
Route::get('/card-deny/{guest}/response', [HomeController::class, 'deny']);

Route::resource('/event', EventController::class);

Route::get('/guest/{guest}/edit', [GuestController::class, 'edit']);
Route::post('/guest/{guest}/create', [GuestController::class, 'store']);
Route::put('/guest/{event}', [GuestController::class,'update']);
Route::delete('/guest/{event}', [GuestController::class, 'destroy']);
Route::get('/guest/{guest}/check', [GuestController::class, 'check']);

Route::get('/profile', [HomeController::class, 'profile']);
