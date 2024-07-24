<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use App\Models\OrderItem;
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
            'address' => "required|string|min:1",
        ]);

        // Add the credentials of the user to the database
        $user = User::create([
            'name' => $request->name,
            'phoneNumber' => $request->phoneNumber,
            'password' => bcrypt($request->password),
            'address' => $request->address,
            'role' => 'customer',
        ]);

        // Give the auth to the user
        Auth::login($user);

        // Return  to the home page
        session()->flash('status', 'You created a account successfully');
        return redirect('/');
    }

    public function profile()
    {
        return view('pages.User.profile');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:4', Rule::unique('Users')->ignore(Auth::id()),],
            'address' => 'max:255|min:10',
        ]);
        $user = Auth::user();

        if ($user) {
            User::where('id', $user->id)->update([
                'name' => $request->name,
                'address' => $request->address
            ]);
            session()->flash('status', 'Your profile is updated successfully');
        }

        return redirect()->back();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function showCart()
    {
        $items = Item::get();
        return view("pages.User.cart", compact('items'));
    }

    public function placeOrder(Request $request)
    {
        if (!Auth::check()) {
            session()->flash('status', 'Please Login | Sign up to Checkout!');
            return response()->json(["login" => true]);
        }
        $body = $request->all();
        $items = $body["cartItem"];
        $total = 0;

        foreach ($items as $item) {
            $price = Item::where('id', $item[0])->value('price');
            $quantity = $item[1];
            $total += (float) ($price * $quantity);
        }

        $order = Order::create([
            "cashier_id" => null,
            "driver_id" => null,
            "waiter_id" => null,
            "customer_id" => Auth::id(),
            "type" => 'Delivery',
            "status" => "Ongoing",
            "total" => $total
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                "order_id" => $order["id"],
                "quantity" => $item[1],
                "item_id" => $item[0],
            ]);
        }

        if ($order) {
            session()->flash('status', 'Your order has been placed Successfully!');
            return response()->json(["Success" => true]);
        } else {
            session()->flash('status', 'Something went Wrong!');
            return response()->json(["Success" => false]);
        }
    }
}
