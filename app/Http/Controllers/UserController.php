<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showLoginForm()
    {
        // Show the login form
        return view('pages.User.login');
    }

    public function showRegistrationForm()
    {
        return view('pages.User.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'phoneNumber' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        } else {
            return back()->withErrors(['email' => 'Invalid Email or password']);
        }
    }

    public function userRegister(Request $request)
    {
        // $request the data and validate it
        $request->validate([
            'name' => 'required|string|unique:Users|min:4',
            'phoneNumber' => 'required|string|unique:Users|min:8',
            'password' => "required|confirmed|min:8",
        ]);

        // Add the credentials of the user to the database 
        $user = User::create([
            'name' => $request->name,
            'phoneNumber' => $request->phoneNumber,
            'password' => bcrypt($request->password),
            'role' => 'user',
        ]);

        // Give the auth to the user 
        Auth::login($user);

        // Return  to the home page
        return redirect('/');
    }

    public function profile()
    {
        return view('User.profile');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:Users|max:255|min:4',
        ]);
        $user = Auth::user();
        if ($user) {
            // Update the name based on the userid
            User::where('id', $user->id)->update(['name' => $request->name]);
            session()->flash('status', 'Your name is updated successfully');
        }

        return redirect()->back();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
