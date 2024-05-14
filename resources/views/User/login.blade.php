@extends('components.layout')

@section('title', 'Login')

@section('content')
    <style>
        body {
            background-color: #006B60;
        }
    </style>
    <div class="w-full h-2/4 flex flex-col justify-center items-center h-svh">
        <form action="/loginC" method="post" class="shadow-xl shadow-black rounded-xl bg-white p-10 w-2/4 flex flex-col">
            <h1 class="text-2xl text-Primary text-center">LOGIN HERE</h1>
            <a href="{{ url()->previous() }}">
                Return Back</a>
            @csrf
            <x-input name="name" type="text" label="name" />
            <x-input name="password" type="password" label="Password" />
            <div class="flex flex-col justify-center items-center w-full mt-5">
                <button type="submit" class="text-white bg-PrimaryD w-1/4">Login</button>
                <p class="font-xs mt-5">Don't have a Account? <a href="/register" class="text-blue-600 font-xs">Registe
                        Here!</a></p>
            </div>
        </form>
    </div>
@endsection
