<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
            'address1' => "required|string|min:1",
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

        Address::create([
            'user_id' => $user->id,
            'address1' => $request->address1,
        ]);

        // Return  to the home page
        session()->flash('status', 'You created a account successfully');
        return redirect('/');
    }

    public function profile()
    {
        $addresses = Address::where('user_id', Auth::user()->id)->get();
        $address1 = $addresses[0]->address1;
        $address2 = $addresses[0]->address2;
        $address3 = $addresses[0]->address3;
        $address4 = $addresses[0]->address4;
        $data = [$address1, $address2, $address3, $address4];
        return view('pages.User.profile', compact('data'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            // check the name is unique and to check that the name is not the same so to pass the check
            // ( la yichuf iza ma 8ayr el user el esem la ma y3mil check 3al name)
            'name' => ['required', 'string', 'max:255', 'min:4', Rule::unique('users')->ignore(Auth::id()),],
            'address1' => 'max:255|min:10',
            'address2' => 'string|max:255|min:10|nullable',
            'address3' => 'string|max:255|min:10|nullable',
            'address4' => 'string|max:255|min:10|nullable',
        ]);
        $user = Auth::user();
        
        if ($user) {
            // Update the name based on the userid
            User::where('id', $user->id)->update(['name' => $request->name]);
        
            Address::where('user_id', $user->id)->update([
                'address1' => $request->address1,
                'address2' => $request->address2,
                'address3' => $request->address3,
                'address4' => $request->address4,
            ]);
            session()->flash('status', 'Your profile is updated successfully');
        }

        return redirect()->back();
    }

    public function deleteAddress(Request $request, $address){
        if(Auth::check()){
            $deleted = Address::where('user_id', Auth::user()->id)->where($address, '!=', $address)->update([$address => null]);
            if($deleted){
                session()->flash('status', 'Address deleted successfully');
                return redirect()->back();
            } else{
                session()->flash('status', 'Something went wrong');
                return redirect()->back();
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
