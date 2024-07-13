@extends('components.layout')

@section('title', 'User | Cart')

@section('content')
    @include('partials._navbar')
    <form action="">
        <div class="w-full flex justify-center">
            <div class="w-11/12 flex flex-col items-center">
                @auth
                    <div class="flex flex-col w-full items-center">
                        <div class="flex flex-col w-11/12">
                            <label for="name" class="text-2xl text-Primary">Name</label>
                            <input type="text" name="name" class="border-2 border-Primary rounded-xl text-xl p-2"
                                value="{{ Auth::user()->name }}">
                            <a href="/user/profile" class="float-right flex">Edit name <img
                                    src="{{ asset('assets/svg/Edit.svg') }}"
                                    class="w-4
                                    "></a>
                        </div>

                        <div class="flex flex-col w-11/12 mt-5">
                            <label for="phoneNumber" class="text-2xl text-Primary">Phone Number</label>
                            <input type="text" name="phoneNumber" class="border-2 border-Primary rounded-xl text-xl p-2"
                                value="{{ Auth::user()->phoneNumber }}">
                            <a href="/user/profile" class="float-right flex">Edit
                                name <img src="{{ asset('assets/svg/Edit.svg') }}" class="w-4"></a>
                        </div>

                        <div class="w-11/12 mt-5" id="test">
                        </div>

                        <div class="flex justify-between border-b-2 border-Primary text-xl w-11/12 mt-5">
                            <p>Total</p>
                            <p id="totalPrice"></p>
                        </div>

                        <button class="w-1/4 bg-Primary text-white text-xl p-2 rounded-xl my-5">Place Order</button>
                    </div>
                @endauth
            </div>
        </div>
    </form>
@section('scripts')
    <script src="{{ asset('assets/js/cart.js') }}"></script>
@endsection
@endsection
