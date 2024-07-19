@extends('components.layout')

@section('title', 'Waiters Page')

@section('content')
    @include('partials._navbar')
    <div class="w-full flex flex-col items-center justify-center" id="allOrder">
    </div>
    <link rel="stylesheet" href="{{ asset('assets/css/waiter.css') }}">

    <div class="w-full flex flex-col justify-center items-center">
        @foreach ($orders as $order)
            <x-cardDropDown :extended="0" compressedStyles="flex justify-between text-center" extendedStyles="flex flex-col"
                wrapperStyles="w-11/12 mt-3">
                <x-slot name="compressed">
                    <h1>{{ $order->id }}</h1>
                    <div class="flex">
                        @foreach ($order->items as $items)
                            <h1 class="mx-1">{{ $items->item->name }}</h1>
                        @endforeach
                    </div>
                </x-slot>

                <x-slot name="slot">
                    <div class="flex justify-between w-full">
                        <p>Order ID: {{ $order->id }}</p>
                        <button class="py-1 px-3 bg-Primary text-white rounded-xl"
                            onclick="goToPOS({{ $order->id }})">POS</button>
                    </div>
                    <div class="text-Primary flex justify-between">
                        <div class="text-center border-r-2 border-b-2 border-S w-full">Item Name</div>
                        <div class="text-center border-r-2 border-b-2 border-S w-full">Quantity</div>
                        <div class="text-center border-r-2 border-b-2 border-S w-full">Action</div>
                    </div>
                    <div id="orderItemsContainer" class="flex flex-col w-full">
                        @foreach ($order->items as $items)
                            <div class="flex justify-between bg-Primary p-3 rounded-xl text-white mt-2 items-center">
                                <div class="text-center w-full">
                                    <p>{{ $items->item->name }}</p>
                                </div>
                                <div class="text-center w-full">
                                    <p id="{{ $items->item->id }}quan">{{ $items->quantity }}</p>
                                </div>
                                <div class="text-center w-full">
                                    <button
                                        onclick="editItem({{ $items->item->id }}, {{ $items->quantity }}, {{ $order->id }})"><img
                                            class="w-8" src="{{ asset('assets/svg/Edit.svg') }}"
                                            alt=""></button>
                                </div>
                            </div>
                        @endforeach
                        <div class="flex float-right mt-5">
                            <button class="bg-Primary rounded-lg py-2 px-5 text-white"
                                onclick="checkout({{ $order->id }})">Checkout</button>
                            <button class="mx-5" onclick="collapseOrder({{ $order->id }}, this)"><img class="w-8"
                                    src="${svgURl + 'ArrowUp.svg'}" alt=""></button>
                        </div>
                    </div>
                </x-slot>
            </x-cardDropDown>
        @endforeach
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/waiters.js') }}"></script>
    <script src="{{ asset('assets/js/cardDropDown.js') }}"></script>
@endsection
