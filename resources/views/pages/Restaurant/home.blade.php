@extends('components.layout')

@section('title', 'Home')

@section('content')
    @include('partials._navbar')
    <x-slider />
    <div class="flex justify-center">
        <input type="" class="bg-Secondary text-white outline-none rounded-xl w-11/12 p-2 text-xl"
            placeholder="Search for Itmes...">
    </div>
    <div class="flex overflow-x-scroll mt-5 w-full">
        @foreach ($categories as $category)
            <div class="bg-Secondary rounded-xl text-xl mx-5 p-2 text-white w-1/4 text-center">
                <a class="block w-32 whitespace-nowrap overflow-hidden text-ellipsis">{{ $category->name }}</a>
            </div>
        @endforeach
    </div>

    <div class="flex w-full justify-center">
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
    <script src="{{ asset('assets/js/slider.js') }}"></script>
@endsection
