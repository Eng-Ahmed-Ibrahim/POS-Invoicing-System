<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{



    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();
    
        if ($user && Hash::check($credentials['password'], $user->password)) {
            
            $remember = $request->has('remember'); // Check if 'remember' checkbox is checked

            // Login the user with the 'remember' option
            Auth::login($user, $remember);
    
            // Debugging: Check if user is authenticated
            if (Auth::check()) {
                return redirect()->route('home');
            } else {
                session()->flash('error', 'Failed to log in');
            }
        } else {
            session()->flash('error', 'The email or password is incorrect');
        }
    
        return back();
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }
}
