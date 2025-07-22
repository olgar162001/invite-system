<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AuditHelper;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;



class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->only('showLoginForm');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->status == 0) {
                Auth::logout();
                return back()->withErrors(['message' => 'Your account is inactive. Contact support.']);
            }

            if ($user->isAdmin()) {
                AuditHelper::log('Login', 'Admin logged into the system');
                return redirect()->route('home')->with('success', 'Login Successful'); // Redirect admin
            }

            AuditHelper::log('Login', 'Customer logged into the system');
            return redirect()->route('home')->with('success', 'Login Successful'); // Redirect customer
        }

        return back()->withErrors(['email' => 'Invalid Login credentials.']);
    }


    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }


    public function logout(Request $request)
    {
        if (session()->has('impersonate_admin_id')) {
            return redirect()->route('stop.impersonation');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        AuditHelper::log('Logout', 'User logged out the system');

        return redirect('login')->with('success', 'Logged out successfully.');
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

        // Store the admin ID in session before impersonation
        session(['impersonate_admin_id' => auth()->id()]);

        // Log in as the customer
        Auth::login($customer);
        AuditHelper::log('Login as customer', 'Impersonated a customer');

        return redirect()->route('home')->with('success', 'You are now logged in as a customer.');
    }

    public function stopImpersonation()
    {
        $adminId = session('impersonate_admin_id');

        if ($adminId) {
            $admin = User::find($adminId);

            if ($admin) {
                Auth::login($admin); // Log back in as the admin
            }

            session()->forget('impersonate_admin_id'); // Clean up
        }
        AuditHelper::log('Logged out as customer', 'User stopped Impersonating as customer');
        return redirect()->route('home')->with('success', 'You are now back as admin.');
    }


}
