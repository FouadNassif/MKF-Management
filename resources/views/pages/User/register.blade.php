@extends('components.layout')

@section('title', 'Register')

@section('content')
    <style>
        body {
            background-color: #006B60;
        }
    </style>
    <div class="w-full h-2/4 flex flex-col justify-center items-center h-svh">
        <form action="/register" method="post"
            class="shadow-xl shadow-black rounded-xl bg-white p-10 w-2/4 flex flex-col">
            <h1 class="text-2xl text-Primary text-center">SIGNUP HERE</h1>
            <a href="{{ url()->previous() }}">< Return Back</a>
            @csrf
            <x-input name="name" type="text" label="name"/>
            <x-input name="password" type="password" label="Password"/>
            <x-input name="password_confirmation" type="password" label="Confirm Password"/>
            <x-input name="phoneNumber" type="text" label="Phone Number"/>
            <x-input name="address" type="text" label="address"/>
            <div class="flex flex-col justify-center items-center w-full mt-5">
                <button type="submit" class="text-white bg-PrimaryD w-1/4">submit</button>
                <p class="font-xs mt-5">Already have a Account? <a href="/login" class="text-blue-600 font-xs">Login Here!</a></p>
            </div>
        </form>
    </div>
@endsection
