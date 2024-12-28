<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Show the combined Login/Register form.
     */
    public function showLoginRegisterForm()
    {
        return view('auth.login-register'); // Render the login-register view
    }

    /**
     * Handle Combined Login or Registration Action.
     */
    public function loginOrRegister(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($request->input('action') === 'login') {
            // Handle login
            if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
                $request->session()->regenerate();
                return redirect()->route('welcome')->with('success', 'Logged in successfully.');
            }

            return back()->withErrors(['login' => 'Invalid login credentials.']);
        } elseif ($request->input('action') === 'register') {
            // Handle registration
            $registerData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|confirmed|min:8',
            ]);

            User::create([
                'name' => $registerData['name'],
                'email' => $registerData['email'],
                'password' => Hash::make($registerData['password']),
            ]);

            return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
        }

        return redirect()->route('login')->withErrors(['action' => 'Invalid action specified.']);
    }

    /**
     * Handle Separate Registration Logic.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
    }

    /**
     * Handle Login Logic.
     */
    private function handleLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Validate login credentials
        $validator = Validator::make($credentials, $this->loginValidationRules());
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['login' => 'Invalid input provided.'])->withInput();
        }

        try {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('welcome')->with('success', 'Welcome back!');
            }

            return redirect()->back()->withErrors(['login' => 'Invalid email or password.'])->withInput();
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['login' => 'An unexpected error occurred during login.'])->withInput();
        }
    }

    /**
     * Validation Rules for Login.
     */
    private function loginValidationRules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ];
    }

    /**
     * Validation Rules for Registration.
     */
    private function registrationValidationRules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    /**
     * Logout the user.
     */
    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('success', 'Logged out successfully.');
        } catch (\Exception $e) {
            Log::error('Logout error: ' . $e->getMessage());
            return redirect()->route('login')->withErrors(['logout' => 'An error occurred while logging out.']);
        }
    }
}
