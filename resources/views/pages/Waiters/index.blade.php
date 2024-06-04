@extends('components.layout')

@section('title', 'User | Cart')

@section('content')
    <div class="w-11/12 flex flex-col">
        <div class="my-5 flex justify-between border-2 rounded-xl border-Primary p-5 w-full">
            <p>5</p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque, culpa!</p>
            <p>^</p>
        </div>
        <div>
            <div class="border-2 border-Primary p-4 rounded-xl">
                <div class="flex justify-between">
                    <p>1</p>
                    <button class="py-1 px-3 bg-Primary text-white rounded-xl">Add Item</button>
                </div>

                <div class="text-Primary flex justify-between ">
                    <div class="text-center border-r-2 border-b-2 border-S w-full">
                        Item Name
                    </div>
                    <div class="text-center border-r-2  border-b-2 border-S w-full">
                        Quantity
                    </div>
                    <div class="text-center border-r-2  border-b-2 border-S w-full">
                        Action
                    </div>
                </div>

                <div class="flex justify-between w-full flex-col ">
                    <div class="flex justify-between bg-Primary p-3 rounded-xl text-white mt-8 items-center">
                        <div class="text-center w-full">
                            <p>Lorem ipsum dolor sit amet.</p>
                        </div>
                        <div class="text-center w-full">
                            <p>Lorem ipsum dolor sit amet.</p>
                        </div>
                        <div class="text-center w-full">
                            <button><img class="w-8" src="{{ asset('assets/svg/Edit.svg') }}" alt=""></button>
                        </div>
                    </div>

                    <div class="flex justify-between bg-Primary p-3 rounded-xl text-white mt-8 items-center">
                        <div class="text-center w-full">
                            <p>Lorem ipsum dolor sit amet.</p>
                        </div>
                        <div class="text-center w-full">
                            <p>Lorem ipsum dolor sit amet.</p>
                        </div>
                        <div class="text-center w-full">
                            <button><img class="w-8" src="{{ asset('assets/svg/Edit.svg') }}" alt=""></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex float-right mt-5">
                <button class=" bg-Primary rounded-lg py-2 px-5 text-white">Checkout</button>
                <button class="mx-5"><img class=" w-8" src="{{ asset('assets/svg/ArrowUp.svg') }}"
                        alt=""></button>
            </div>
        </div>

        <div class="my-5 flex justify-between border-2 rounded-xl border-Danger p-5 w-full">
            <p>5</p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque, culpa!</p>
            <p>^</p>
        </div>
    </div>

@endsection
