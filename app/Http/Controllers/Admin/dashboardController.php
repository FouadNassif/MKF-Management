<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Item;

class dashboardController extends Controller
{
    public function index(){
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

    public function destroyDrivers($id)
    {
        // Find the driver by ID and delete it
        $driver = User::findOrFail($id);
        $driver->delete();

        // Redirect back with a success message
        return redirect()->route('pages.admin.driver');
    }

    // driver controller

    public function getWaiters()
    {
        $waiters = User::where('role', 'waiter')->get();
        return view('pages.admin.waiter', compact('waiters'));
    }

    public function destroyWaiters($id)
    {
        // Find the waiter by ID and delete it
        $waiter = User::findOrFail($id);
        $waiter->delete();

        // Redirect back with a success message
        return redirect()->route('pages.admin.waiter');
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

    public function addItems(){
        return view('pages.admin.addItems');
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

        $item = new Item();
        $item->name = $request->name;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->imageURL = $request->imageURL;
        $item->category_id = $request->category_id;
        $item->save();

        return redirect()->route('items.create')->with('success', 'Item added successfully');
    }
}
