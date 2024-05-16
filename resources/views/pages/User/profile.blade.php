@extends('components.layout')

@section('title', 'Profile')

@section('content')
    @include('partials._navbar')
    @auth
        <div class="flex flex-col w-full justify-center items-center">
            <div class="border-2 border-Primary rounded-full p-10">
                <img src="{{ asset('assets/svg/Profile.svg') }}" class="w-40">
            </div>
            <div class="w-full">
                <form action="{{ route('user.updateProfile') }}" method="post"
                    class="w-full flex flex-col justify-center items-center">
                    @csrf
                    <div class="mt-5 w-3/4">
                        <label for="name" class="text-Primary font-medium text-xl">Name</label>
                        @error('name')
                            <span class="text-red-600 font-bold ml-5">*{{ $message }}</span>
                        @enderror
                        <input type="text" id="name" name="name" value="{{ Auth::user()->name }}"
                            class="w-full bg-transparent outline-0 cursor-pointer mt-4 border-2 rounded-xl border-Primary p-2">
                    </div>

                    <div class="mt-5 w-3/4">
                        <label for="phoneNumber" class="text-Primary font-medium text-xl">Phone Number</label>
                        @error('phoneNumber')
                            <span class="text-red-600 font-bold ml-5">*{{ $message }}</span>
                        @enderror
                        <input type="text" id="phoneNumber" name="phoneNumber" value="{{ Auth::user()->phoneNumber }}"
                            class="w-full bg-transparent outline-0 cursor-pointer mt-4 border-2 rounded-xl border-Primary p-2">
                    </div>
                    <div class="mt-5 w-3/4">
                        @php
                            $showInput = true;
                        @endphp
                        @foreach ($data as $i => $address)
                            @if ($address != null)
                                <div>
                                    <x-addressInput :index='($i + 1)' address={{$address}}/>
                                    <div class="flex items-center justify-center ">
                                        @if ($i > 0)
                                            <a href="{{ route('user.deleteAddress', 'address' . ($i + 1)) }}">
                                                <img src="{{ asset('assets/svg/DeleteLocation.svg') }}" class="w-12">
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @else
                                @if ($showInput)
                                    <button type="button" id="butAd{{ $i + 1 }}" onclick="addAddressInput(this)"
                                        class="border-2 rounded-xl border-Primary text-xl text-Primary font-bold p-2 hover:bg-Primary hover:text-white mt-5">Add
                                        Address+</button>
                                    {{ $showInput = false }}
                                @endif
                            @endif
                        @endforeach
                    </div>
                    <div id="moreAddressCon" class="w-9/12">
                    </div>
                    <div class="w-2/4 flex justify-center mt-5">
                        <button type="submit" class="text-white bg-Primary p-2 px-5 rounded-full text-xl w-1/4">Save</button>
                        <button type="reset"
                            class="text-Primary border-2 border-Primary p-2 px-5 rounded-full text-xl w-1/4">Cancel</button>
                    </div>

                </form>
            </div>
        </div>
    @endauth
@endsection
<script>
    function addAddressInput(button) {
        let numbInput = button.id[5];
        let label =
            `<label for="address${numbInput}" class="text-Primary font-medium text-xl">Address${numbInput}</label>`
        let input =
            `<input name='address${numbInput}' type='text' placeholder='Add a new Address(minimum 10 characters)' class='w-full bg-transparent outline-0 cursor-pointer mt-4 border-2 rounded-xl border-Primary p-2'>`
        let res = label + input;
        document.getElementById("moreAddressCon").innerHTML = res;
        console.log(document.getElementById("t").textContent)
    }
</script>
