@extends('components.layout')

@section('title', 'Home')

@section('content')
    @include('partials._navbar')
    <x-slider/>
    <div class="flex justify-center">
        <input type="" class="bg-Secondary text-white outline-none rounded-xl w-11/12 p-2 text-xl"
            placeholder="Search for Itmes...">
    </div>
    <div class="flex overflow-x-scroll mt-5">
        <?php
        $ItemsCategory = ['seafood', 'sandwiches', 'pizza', 'burgers', 'drinks', 'seafood', 'sandwiches', 'pizza', 'burgers', 'drinks', 'seafood', 'sandwiches', 'pizza', 'burgers', 'drinks'];
        ?>
        @foreach ($ItemsCategory as $category)
            <h1 class="bg-Secondary rounded-xl text-xl mx-5 p-2 text-white">{{ $category }}</h1>
        @endforeach
    </div>
    <div class="flex flex-wrap justify-center">
        @for ($i = 0; $i < 10; $i++)
            <x-item-card />
        @endfor
    </div>
@endsection
