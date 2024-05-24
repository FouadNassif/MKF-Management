<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function homePage()
    {
        $items = Item::get();
        $categories = ItemCategory::get();
        return view('pages.Restaurant.home', compact('items', 'categories'));
    }
    public function index()
    {
        return Item::all();
    }

    public function create(Request $request)
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "price" => "required|numeric",
            "description" => "string",
            "imageURL" => "required"
        ]);

        $logoPath = null;
        if ($request->hasFile('imageURL')) {
            $logoPath = $request->file('imageURL')->store('itemImage', 'public'); // heyde 7a tred itemImage/imagePath
            $logoPath = basename($logoPath); // basename bichil el itemImage w bired el imagepath 
        }

        Item::create([
            "name" => $request->name,
            "price" => $request->price,
            "description" => $request->description,
            "category_id" => 2,
            "imageURL" => $logoPath
        ]);


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
            "price" => "required",
            "category_id" => "required",
            "description" => "string"
        ]);

        $item->update($request->all());

        return redirect()->back()->with("success", "Item updated successfully");
    }
}
