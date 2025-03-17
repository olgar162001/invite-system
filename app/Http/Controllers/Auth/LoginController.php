<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;



class LoginController extends Controller
{

    public function showLoginForm(){
        return view('auth.login');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->status == 0) {
                Auth::logout();
                return back()->withErrors(['message' => 'Your account is inactive. Contact support.']);
            }

            if ($user->isAdmin()) {
                return redirect()->route('home'); // Redirect admin
            }

            return redirect()->route('home'); // Redirect customer
        }

        return back()->withErrors(['email' => 'Invalid login credentials.']);
    }


    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }


    /**
     * Handle the callback from the social authentication provider.
     */
    public function handleProviderCallback($provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        // Find or create user
        $user = User::updateOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name' => $socialUser->getName(),
                'provider_id' => $socialUser->getId(),
                'provider' => $provider,
                'password' => bcrypt(uniqid()), // Generate a random password
            ]
        );

        // Authenticate the user
        Auth::login($user, true);

        // Redirect to home if authentication is successful
        return redirect()->route('home')->with('success', 'Logged in successfully!');
    }


    public function impersonateUser($customerId)
    {  
        $customer = User::where('role', 'customer')->findOrFail($customerId);
        
        Auth::logout(); // Log out the admin
        Auth::login($customer); // Log in as the customer

        return redirect()->route('home')->with('success', 'You are now logged in as a customer.');
    }

}
