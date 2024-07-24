@extends('components.layout')
@include('partials._navbar')
<div class="flex">
    <div class="flex flex-col w-64 h-screen bg-Primary border-r  sticky">
        <div class="flex items-center justify-center h-16 border-b">
            <h1 class="text-xl text-white">MKF management</h1>
        </div>
        <div class=" p-5 ">
            <div class="p-4 my-4 bg-PrimaryD text-center text-xl rounded">
                <a href="{{ route('pages.admin.orders') }}" class="text-white">Orders</a>
            </div>
            <div class="p-4 mt-4 bg-PrimaryD text-center text-xl rounded">
                <a href="{{ route('pages.admin.waiter') }}" class="text-white">Waiters</a>
            </div>
            <div class="p-4 mt-4 bg-PrimaryD text-center text-xl rounded">
                <a href="{{ route('pages.admin.driver') }}" class="text-white">Drivers</a>
            </div>
            <div class="p-4 mt-4 bg-PrimaryD text-center text-xl rounded">
                <a href="{{ route('pages.admin.customer') }}" class="text-white">Customers</a>
            </div>
            <div class="p-4 mt-4 bg-PrimaryD text-center text-xl rounded">
                <a href="{{ route('pages.admin.menuItems') }}" class="text-white">Menu Item</a>
            </div>
        </div>
    </div>
