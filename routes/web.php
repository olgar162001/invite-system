<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\WhatsAppController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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


Route::get('/auth/{provider}', function ($provider) {
    return Socialite::driver($provider)->redirect();
})->name('social.redirect');

Route::get('/auth/{provider}/callback', function ($provider) {
    $socialUser = Socialite::driver($provider)->user();

    // Find or create user
    $user = User::updateOrCreate(
        ['email' => $socialUser->getEmail()],
        [
            'name' => $socialUser->getName(),
            'provider_id' => $socialUser->getId(),
            'provider' => $provider,
            'password' => bcrypt(uniqid()), // Random password
        ]
    );

    // Ensure user is authenticated
    Auth::login($user, true); 

    // Debugging: Check if user is authenticated
    if (Auth::check()) {
        return redirect('/home')->with('success', 'Logged in successfully!');
    } else {
        return redirect('/login')->with('error', 'Authentication failed.');
    }
})->name('social.callback');


Route::get('/auth/facebook', function () {
    return Socialite::driver('facebook')->redirect();
});

Route::get('/auth/facebook/callback', function () {
    $facebookUser = Socialite::driver('facebook')->user();
    
    // Check if user exists, if not, create one
    $user = User::updateOrCreate([
        'email' => $facebookUser->getEmail(),
    ], [
        'name' => $facebookUser->getName(),
        'facebook_id' => $facebookUser->getId(),
        'password' => bcrypt('password') // You might want to improve this
    ]);

    Auth::login($user, true);

    return redirect('/home'); // Redirect after login
});


// Show forgot password form
Route::get('/forgot-password', function () {
    return view('auth.passwords.forgot');
})->middleware('guest')->name('password.request');

// Handle sending password reset email
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email|exists:users,email']);

    Password::sendResetLink($request->only('email'));

    return back()->with('status', 'Password reset link sent!');
})->middleware('guest')->name('password.email');

// Show reset password form
Route::get('/reset-password/{token}', function ($token) {
    return view('auth.passwords.reset', ['token' => $token]);
})->middleware('guest')->name('password.reset');

// Handle reset password submission
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'password' => 'required|min:8|confirmed',
        'token' => 'required'
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password),
                'remember_token' => Str::random(60),
            ])->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', 'Password has been reset successfully.')
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');



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

Route::post('/send-whatsapp', [WhatsAppController::class, 'sendMessage']);
Route::get('/event/{event}/guest/search', [GuestController::class, 'search'])->name('guest.search');
