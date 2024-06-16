<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')->get();
        return view('pages.admin.customer', compact('customers'));
    }

    public function destroy($id)
    {
        // Find the item by ID and delete it
        $customer = User::findOrFail($id);
        $customer->delete();

        // Redirect back with a success message
        return redirect()->route('pages.admin.customer');
    }
}
