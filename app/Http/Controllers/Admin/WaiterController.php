<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class WaiterController extends Controller
{
    public function index()
    {
        $waiters = User::where('role', 'waiter')->get();
        return view('pages.admin.waiter', compact('waiters'));
    }

    public function destroy($id)
    {
        // Find the item by ID and delete it
        $waiter = User::findOrFail($id);
        $waiter->delete();

        // Redirect back with a success message
        return redirect()->route('pages.admin.waiter');
    }
}
