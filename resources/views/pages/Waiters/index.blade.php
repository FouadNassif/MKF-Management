@extends('components.layout')

@section('title', 'Waiters Page')

@section('content')
    @include('partials._navbar')
    <div class="w-full flex flex-col items-center justify-center" id="allOrder">
    </div>
    <script src="{{ asset('assets/js/waiters.js') }}"></script>
    <link rel="stylesheet" href="{{asset('assets/css/waiter.css')}}">
@endsection
