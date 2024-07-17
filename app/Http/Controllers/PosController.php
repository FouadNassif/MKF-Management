<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PosController extends Controller
{
    public function index()
    {
        return view("pages.Restaurant.pos.pos");
    }

    public function order(Request $request)
    {
        $body = $request->all();
        $items = $body["items"];
        $total = $body["total"];

        $order = Order::create([
            "cashier_id" => Auth::id(),
            "status" => "Not Payed",
            "total" => $total,
            "type" => "DineIn"
        ]);
        foreach ($items as $item) {
            OrderItem::create([
                "order_id" => $order["id"],
                "quantity" => $item["quantity"],
                "item_id" => $item["id"],
            ]);
        }

        return $order;
    }

    public function payment(Request $request)
    {
        $order_id = $request->query("order_id");

        $order = Order::with("items.item")->findOrFail($order_id);

        return view("pages.Restaurant.pos.payment", [
            "order" => $order,
            "items" => $order["items"]
        ]);
    }

    public function paymentStore(Request $request)
    {
        $order_id = $request->input("order_id");
        $order = Order::findOrFail($order_id);

        $updated = $order->update([
            "status" => "payed"
        ]);

        return [
            "status" => $updated,
        ];
    }
}
