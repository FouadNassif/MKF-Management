<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemCategory;

class ItemCategoryController extends Controller
{
    public function index()
    {
        return ItemCategory::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
        ]);

        ItemCategory::create([
            "name" => $request->name,
        ]);

        return redirect()->back()->with("success", "Category added successfully.");
    }


    public function destroy(ItemCategory $category)
    {
        $category->delete();
        return redirect()->back()->with("success", "Category deleted successfully.");
    }

    public function update(Request $request, ItemCategory $category)
    {
        $request->validate([
            "name" => "required",
        ]);
        
        $category->update([
            "name" => $request->name,
        ]);

        return redirect()->back()->with("success", "Category updated successfully");
    }
}
