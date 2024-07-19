<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaitersController extends Controller
{
    public function getAllOrder(Request $request)
    {
        $orders = Order::where("type", "DineIn")->where("waiter_id", Auth::id())->with('items.item')->get();
        return view('pages.Waiters.index', compact('orders'));
    }

    public function getAllOrderJS()
    {

        $orders = Order::where("type", "DineIn")->where("waiter_id", Auth::id())->with('items.item')->get();

        return $orders;
    }


    public function getOrderById(Request $request)
    {
        $body = $request->all();
        if (isset($body['orderId'])) {
            $order = Order::where('id', $body['orderId'])->with('items.item')->first();
            if (!$order) {
                return response()->json(['error' => 'Order not found'], 404);
            }

            $itemsName = [];

            foreach ($order->items as $item) {
                $itemName = Item::where('id', $item->item_id)->value('name');
                $itemsName[$item->item_id] = $itemName;
            }

            return response()->json(['order' => $order, 'itemsName' => $itemsName]);
        }

        return response()->json(['error' => 'Order ID not provided'], 400);
    }

    public function saveEditedOrder(Request $request)
    {
        $body = $request->all();
        if (isset($body['itemId']) && isset($body['orderId'])) {
            $orderItem = OrderItem::where('order_id', $body['orderId'])
                ->where('item_id', $body['itemId'])
                ->first();
            if ($orderItem) {
                // Update the quantity
                $orderItem->quantity = $body['newQuantity'];
                $orderItem->save();
                return response()->json(['message' => 'Order item updated successfully'], 200);
            }
        }
    }
    public function waiterToPos(Request $request)
    {
        $body = $request->all();
        session()->flash('orderId', $body['orderId']);
    }

    function deleteItem(Request $request)
    {
        $body = $request->all();
        if (isset($body['orderId']) && isset($body['itemId'])) {
            $itemDeleted = OrderItem::where('order_id', $body['orderId'])->where('item_id', $body['itemId'])->delete();
            if ($itemDeleted) {
                return response()->json(['deleted' => 'true']);
            } else {
                return response()->json(['deleted' => 'false']);
            }
        }
    }
}
