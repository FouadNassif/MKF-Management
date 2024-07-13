<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = User::where('role', 'driver')->get();
        return view('pages.admin.driver', compact('drivers'));
    }

    public function destroy($id)
    {
        // Find the item by ID and delete it
        $driver = User::findOrFail($id);
        $driver->delete();

        // Redirect back with a success message
        return redirect()->route('pages.admin.driver');
    }
}
