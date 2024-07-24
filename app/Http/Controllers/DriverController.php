<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    function index()
    {
        $orders = Order::get()->where('type', '==', 'Delivery');
        return view('pages.Restaurant.driver', ['orders' => $orders, 'auth_id' => Auth::user()->id]);
    }

    function deliverOrder(Order $order)
    {
        $order->update([
            'driver_id' => Auth::user()->id
        ]);

        $orders = Order::get()->where('type', '==', 'Delivery');

        return redirect()->route('driver.index');
    }

    function goToCheckout(Order $order)
    {
        return redirect()->route('pos.payment.index', ['order_id'=> $order->id]);
    }
}
