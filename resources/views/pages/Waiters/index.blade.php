@extends('components.layout')

@section('title', 'Waiters Page')

@section('content')
    @include('partials._navbar')
    <div class="w-full flex flex-col items-center justify-center" id="allOrder">
    </div>
    <script src="{{ asset('assets/js/waiters.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/waiter.css') }}">
    {{-- <!-- resources/views/example.blade.php -->

    <x-cardDropDown :extended="1">

        <x-slot name="compressed">
            Compressed content goes here.
        </x-slot>
        <x-slot name="slot">
            Lore
        </x-slot>
        </x-drop-down-card>
        @section('scripts')
        <script src="{{asset('assets/js/cardDropDown.js')}}"></script>
        @endsection --}}
@endsection
