@extends('components.layout')

@section('title', 'Home')

@section('content')
    @include('partials._navbar')
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
    <div class="relative">
        <div id="cart"
            class="fixed top-0 right-0 w-4/12 bg-PrimaryD p-5 text-black h-screen flex flex-col justify-between z-40 shadow-lg transform translate-x-full transition-transform duration-300">
            <div class="relative">
                <button id="cartButton"
                    class="fixed top-1/2 -left-12 transform -translate-y-1/2 bg-PrimaryD text-white p-3 rounded-l-lg z-50">
                    <img id="butImgCart" src="{{ asset('assets/svg/CartOpen.svg') }}" class="w-10">
                    <span id="cartItemsCounter"
                        class="absolute top-0 left-0 transform -translate-x-1/2 -translate-y-1/2 bg-cyan-950 text-2xl px-3 rounded-full text-white">0</span>
                </button>
            </div>

            <div class="flex-grow overflow-y-auto" id="test">
            </div>
            <div class="flex w-full justify-center">
                <button type="button" class="flex justify-between bg-Primary p-2 rounded-lg px-4 w-2/4 text-white text-xl">
                    <p>Checkout</p>
                    <p id="totalPrice"></p>
                </button>
            </div>
        </div>

        <x-slider />
        <div class="flex justify-center">
            <input type="text" id="itemSearchInp"
                class="bg-Secondary text-white outline-none rounded-xl w-11/12 p-3 text-xl placeholder:text-white"
                placeholder="Search for Items...">
        </div>
        <div class="flex items-center mt-5 w-full">
            <button id="scrollLeft" class="bg-transparent p-2mx-3">
                <img src="{{ asset('assets/svg/LeftArrow.svg') }}" aclass="w-12">
            </button>
            <div class="flex overflow-x-scroll no-scrollbar w-full" id="categoryContainer">
                @foreach ($categories as $category)
                    <button
                        class="bg-Secondary rounded-xl text-xl mx-5 py-3 px-4 text-white text-center min-w-[100px] hover:bg-SecondaryH"
                        onclick="searchByCategory('{{ $category->id }}')">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
            <button id="scrollRight" class="bg-transparent p-2 mx-3">
                <img src="{{ asset('assets/svg/LeftArrow.svg') }}" class="w-12 rotate-180">
            </button>
        </div>

        <div class="flex w-full justify-center flex-wrap min-h-96" id="itemContainer">
            @foreach ($items as $item)
                <x-item-card :item="$item" />
            @endforeach
        </div>
        <div id="modalCon">
            
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/slider.js') }}"></script>
    <script src="{{ asset('assets/js/home.js') }}"></script>
    <script src="{{ asset('assets/js/SearchFilter.js') }}"></script>
@endsection
