@extends('components.layout')

@section('title', 'Home')

@section('content')
    @include('partials._navbar')
    <link rel="stylesheet" href="{{asset('assets/css/home.css')}}">
    <x-slider />
    <div class="flex justify-center">
        <input type=""
            class="bg-Secondary text-white outline-none rounded-xl w-11/12 p-3 text-xl placeholder:text-white"
            placeholder="Search for Itmes... ">
    </div>
    <div class="flex overflow-x-scroll mt-5 w-full">
        @foreach ($categories as $category)
            <div class="bg-Secondary rounded-xl text-xl mx-5 py-3 px-4 text-white text-center">
                <a class="block min-w-20">{{ $category->name }}</a>
            </div>
        @endforeach
    </div>

    @php
        $itemsObj = (object) $items;
    @endphp

    <div class="flex w-full justify-center flex-wrap sm:flex-nowrap" id="itemContainer" data-items=" {{ $itemsObj }}">
        <div>
            @for ($i = 0; $i < count($items) / 3; $i++)
                <x-item-card :item="$items[$i]" />
            @endfor
        </div>
        <div>
            @for ($i = ceil(count($items) / 3); $i < (count($items) / 3) * 2; $i++)
                <x-item-card :item="$items[$i]" />
            @endfor
        </div>
        <div>
            @for ($i = ceil((count($items) / 3) * 2); $i < count($items); $i++)
                <x-item-card :item="$items[$i]" />
            @endfor
        </div>
    </div>
    <div id="modalCon">
        
    </div>
@section('scripts')
    <script src="{{ asset('assets/js/slider.js') }}"></script>
    <script src="{{ asset('assets/js/cart.js') }}"></script>
    <script src="{{ asset('assets/js/home.js') }}"></script>
@endsection
@endsection
