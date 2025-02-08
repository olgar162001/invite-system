<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    

public function googleCallback()
{
    try {
        // Get user details from Google
        $socialUser = Socialite::driver('google')->stateless()->user();

        // Check if user exists in the database
        $user = User::where('email', $socialUser->getEmail())->first();

        // If the user does not exist, create them
        if (!$user) {
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'provider' => 'google',
                'provider_id' => $socialUser->getId(),
                'password' => bcrypt(uniqid()), // Random password
            ]);
        }

        // Log the user in
        Auth::login($user);

        // Redirect to the home/dashboard page
        return redirect('/home'); // Change this to your desired route

    } catch (\Exception $e) {
        return redirect('/login')->with('error', 'Something went wrong.');
    }
}

}
