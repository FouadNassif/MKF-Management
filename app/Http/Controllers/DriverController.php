<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    function index($id)
    {

        if (auth()->user()->role != 'admin' && auth()->user()->id != $id) {
            abort(403, 'Unauthorized action.');
        }

        $orders = Order::get()->where('type', '==', 'Delivery');
        dd($orders[0]['items'][0]['item']);
        return view('pages.Restaurant.driver', ['orders' => $orders]);
    }

    function takeOrder(Order $order)
    {
        $order->update([
            'driver_id' => Auth::user()->id
        ]);

        $orders = Order::get()->where('type', '==', 'Delivery');

        return view('pages.admin.driver', ['orders' => $orders]);
    }
}
