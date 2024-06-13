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
                    <div class="mt-5 w-3/4" id="addressMainCon">
                        @php
                            $showInput = true;
                        @endphp
                        @foreach ($data as $i => $address)
                            <x-addressInput address='{{ $address }}' :index='$i + 1' />
                            <div class="flex items-center justify-center" id="addInputCon{{ $i + 1 }}">
                            </div>
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
    document.addEventListener('DOMContentLoaded', function() {
        let addInputCon = document.getElementById("addInputCon");
        let addressMainCon = document.getElementById("addressMainCon");
        let countAddress = addressMainCon.querySelectorAll("div .address").length;
        let inputAddress = addressMainCon.querySelectorAll('input')
        let temp = 0;
        for(let i =0; i< 4; i++){
            if(inputAddress[i].value != "") temp ++;
        }
        if (countAddress >= 2) {
            for (let i = 1; i <= countAddress; i++) {
                let addInputCon = document.getElementById(`addInputCon${i}`);
                let add = `address${i}`;
                addInputCon.innerHTML += `
            <a href="{{ route('user.deleteAddress', '') }}/${add}">
                <img src="{{ asset('assets/svg/DeleteLocation.svg') }}" class="w-12">
            </a>`;
            }
        }
    });

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
