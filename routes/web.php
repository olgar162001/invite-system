<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EmailSettingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\EmailSettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider and assigned to the "web" middleware group.
|
*/

// Public Routes
Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

// Authentication Routes
// Route::middleware('guest')->group(function () {
Auth::routes();
// });

// Social Authentication Routes
Route::prefix('auth')->group(function () {
    Route::get('{provider}', [LoginController::class, 'redirectToProvider'])->name('social.redirect');
    Route::get('{provider}/callback', [LoginController::class, 'handleProviderCallback'])->name('social.callback');
});

// Password Reset Routes
Route::middleware('guest')->prefix('password')->group(function () {
    Route::get('forgot', [ResetPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('forgot', [ResetPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('reset/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('reset', [ResetPasswordController::class, 'resetPassword'])->name('password.update');
});

// Dashboard/Home Route
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Event & Guest Routes
//Route::middleware(['auth', 'isCustomer','isAdmin'])->group(function () {
Route::resource('/event', EventController::class);
//});

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::resource('/customers', UserController::class);
    Route::get('{guest}/check', [GuestController::class, 'check']);

    Route::get('/calendar', function () {
        return view('calendar');
    })->name('calendar');
});

//Route::middleware(['guest'])->group(function () {
Route::get('{guest}/edit', [GuestController::class, 'edit'])->name('guest.edit');
Route::post('{guest}/create', [GuestController::class, 'store'])->name('guest.store');
Route::put('{guest}', [GuestController::class, 'update'])->name('guest.update');
Route::delete('{guest}', [GuestController::class, 'destroy'])->name('guest.delete');
Route::post('{guest}/import', [GuestController::class, 'import'])->name('guest.import');
//});

// Invitation Response Routes
Route::get('/card-template/{guest}', [GuestController::class, 'show']);
Route::get('/card-confirm/{guest}/response', [HomeController::class, 'confirm']);
Route::get('/card-deny/{guest}/response', [HomeController::class, 'deny']);

// Profile Routes
Route::get('/profile', [HomeController::class, 'profile']);

// Search Route
Route::get('/event/{event}/guest/search', [GuestController::class, 'search'])->name('guest.search');

//Messaging Route
Route::post('/send-whatsapp', [WhatsAppController::class, 'sendMessage']);
Route::post('/send-invitations', [GuestController::class, 'sendInvitations'])->name('send.invitations');

Route::get('/events', [CalendarController::class, 'index'])->name('events.index');

//admin impersonate
Route::get('/impersonate/{customerId}', [LoginController::class, 'impersonateUser'])
    ->middleware(['auth', 'isAdmin'])
    ->name('admin.impersonate');
Route::get('/stop-impersonation', [LoginController::class, 'stopImpersonation'])->name('stop.impersonation');



Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});





// Public/customer view-only route
Route::get('/card-template', [TemplateController::class, 'index'])->name('templates.index');

// Admin-only routes (optional: wrap in admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/templates/create', [TemplateController::class, 'create'])->name('templates.create');
    Route::post('/templates', [TemplateController::class, 'store'])->name('templates.store');
    Route::get('/templates/{template}/edit', [TemplateController::class, 'edit'])->name('templates.edit');
    Route::put('/templates/{template}', [TemplateController::class, 'update'])->name('templates.update');
    Route::delete('/templates/{template}', [TemplateController::class, 'destroy'])->name('templates.destroy');




    Route::get('/sms/settings', [SmsController::class, 'settings'])->name('sms.settings');
    Route::post('/sms/settings', [SmsController::class, 'updateSettings'])->name('sms.settings.update');
    Route::get('/email-settings', [EmailSettingController::class, 'index'])->name('email.settings');
    Route::post('/email-settings', [EmailSettingController::class, 'update'])->name('email.settings.update');

    Route::get('/sms/balance', [SmsController::class, 'balance'])->name('sms.balance');

    Route::get('/sms/assign', [SmsController::class, 'assign'])->name('sms.assign');
    Route::get('/customer/{id}/events', function ($id) {
        $events = Event::where('user_id', $id)->get(['id', 'title']);
        return response()->json($events);
    });
    Route::post('/sms/assign', [SmsController::class, 'assignToCustomer'])->name('sms.assign.store');

});


Route::post('/send-sms', [SmsController::class, 'SendInvaitation'])
    ->middleware(['auth', 'check.sms.units']);

    // Show events on Calendar
Route::get('/events-feed', [EventController::class, 'feed']);
