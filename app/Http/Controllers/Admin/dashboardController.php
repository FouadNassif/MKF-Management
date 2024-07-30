<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class dashboardController extends Controller
{
    public function index()
    {
        return view('pages.admin.dashboard');
    }

    // customer controller

    public function getCustomers()
    {
        $customers = User::where('role', 'customer')->get();
        return view('pages.admin.customer', compact('customers'));
    }

    public function destroyCustomers($id)
    {
        // Find the customer by ID and delete it
        $customer = User::findOrFail($id);
        $customer->delete();

        // Redirect back with a success message
        return redirect()->route('pages.admin.customer');
    }

    // driver controller

    public function getDrivers()
    {
        $drivers = User::where('role', 'driver')->get();
        return view('pages.admin.driver', compact('drivers'));
    }

    public function deleteDriverPassword($id)
    {

        // Find the waiter by ID and delete it
        $driver = User::findOrFail($id);
        // Check if the user has the role 'waiter'
        if ($driver->role === 'driver') {
            // Set the password to null
            $driver->password = "admin1234";
            $driver->save();
            // Redirect back with success message
            return redirect()->route('pages.admin.driver')->with('status', 'Driver password changed successfully!');
        }
    }

    // driver controller

    public function getWaiters()
    {
        $waiters = User::where('role', 'waiter')->get();
        return view('pages.admin.waiter', compact('waiters'));
    }

    public function deleteWaiterPassword($id)
    {
        // Find the waiter by ID and delete it
        $waiter = User::findOrFail($id);
        // Check if the user has the role 'waiter'
        if ($waiter->role === 'waiter') {
            // Set the password to null
            $waiter->password = "admin1234";
            $waiter->save();
            // Redirect back with success message
            return redirect()->route('pages.admin.waiter')->with('status', 'Waiter password changed successfully!');
        }
    }

    // order controller

    public function getOrders()
    {
        $orders = Order::all();
        return view('pages.admin.order', compact('orders'));
    }


    // menu itmes controller

    public function getMenuItems()
    {
        $items = Item::all();
        return view('pages.admin.menuItems', compact('items'));
    }

    public function destroyItem($id)
    {
        // Find the item by ID and delete it
        $item = Item::findOrFail($id);
        $item->delete();

        // Redirect back with a success message
        return redirect()->route('pages.admin.menuItems');
    }

    public function addItems()
    {
        $categories = ItemCategory::all();
        return view('pages.admin.addItems', compact('categories'));
    }

    // add items 
    public function createItem()
    {
        return view('pages.admin.addItems');
    }

    public function storeItem(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'imageURL' => 'required|string',
            'category_id' => 'required|numeric',
        ]);
        $item = Item::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'imageURL' => $request->imageURL,
            'category_id' => $request->category_id,
        ]);
        if ($item) {
            return redirect()->route('pages.admin.menuItems')->with('status', 'Item added successfully');
        }
    }
}
