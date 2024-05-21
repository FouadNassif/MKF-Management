<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        return Item::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "price" => "required|numeric",
            "category_id" => "required",
            "description" => "string"
        ]);

        Item::create($request->all());

        return redirect()->back()->with("success", "Item added successfulyy");
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->back()->with("success", "Item deleted successfully.");
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            "name" => "required",
            "price"=> "required",
            "category_id"=> "required",
            "description" => "string"
        ]);

        $item->update($request->all());

        return redirect()->back()->with("success", "Item updated successfully");
    }
}
