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
                            $count = 0;
                        @endphp
                        @foreach ($data as $i => $address)
                            @if ($address != null)
                                @php
                                    $count++;
                                @endphp
                                <div class="flex items-center justify-center align-center address"
                                    id="addressContainer{{ $i + 1 }}">
                                    <div class="flex flex-col w-full">
                                        <label for="address{{ $i + 1 }}" class="text-Primary font-medium text-xl">Address
                                            {{ $i + 1 }}</label>
                                        <div class="flex items-center w-full">
                                            <input type="text" id="address{{ $i + 1 }}"
                                                name="address{{ $i + 1 }}" value="{{ $address }}"
                                                class="w-full bg-transparent outline-0 cursor-pointer mt-4 border-2 rounded-xl border-Primary p-2">
                                            @if ($i > 0)
                                                <a href="{{ route('user.deleteAddress', 'address' . ($i + 1)) }}">
                                                    <img src="{{ asset('assets/svg/DeleteLocation.svg') }}" class="w-12">
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($count == 4)
                                @php
                                    $showInput = false;
                                @endphp
                            @endif
                        @endforeach
                    </div>
                    <div id="moreAddressCon" class="w-9/12"></div>
                    @if ($showInput)
                        <button type="button" id="butAd" onclick="addAddressInput()"
                            class="border-2 rounded-xl border-Primary text-xl text-Primary font-bold p-2 hover:bg-Primary hover:text-white mt-5">Add
                            Address+</button>
                    @endif
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

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            updateDeleteLinks();
        });

        function updateDeleteLinks() {
            let addressMainCon = document.getElementById("addressMainCon");
            let addresses = addressMainCon.querySelectorAll("div.address");
            let countAddress = addresses.length;

            addresses.forEach((addressDiv, index) => {
                let addressInputCon = addressDiv.querySelector('.flex.items-center.w-full');
                let add = `address${index + 1}`;
                let deleteLink = addressInputCon.querySelector('a');

                if (countAddress > 1) {
                    if (!deleteLink) {
                        addressInputCon.innerHTML += `
                        <a href="{{ route('user.deleteAddress', '') }}/${add}">
                            <img src="{{ asset('assets/svg/DeleteLocation.svg') }}" class="w-12">
                        </a>`;
                    }
                } else {
                    if (deleteLink) {
                        deleteLink.remove();
                    }
                }
            });
        }

        function addAddressInput() {
            let addressMainCon = document.getElementById("addressMainCon");
            let addresses = addressMainCon.querySelectorAll("div.address");
            let currentCount = addresses.length;

            if (currentCount < 4) {
                let newIndex = currentCount + 1;
                for (let i = 1; i <= 4; i++) {
                    if (!document.getElementById(`address${i}`)) {
                        newIndex = i;
                        break;
                    }
                }

                let newAddress = `
                <div class="flex items-center justify-center align-center address" id="addressContainer${newIndex}">
                    <div class="flex flex-col w-full">
                        <label for="address${newIndex}" class="text-Primary font-medium text-xl">Address ${newIndex}</label>
                        <div class="flex items-center w-full">
                            <input type="text" id="address${newIndex}" name="address${newIndex}" placeholder="Add a new Address(minimum 10 characters)" class="w-full bg-transparent outline-0 cursor-pointer mt-4 border-2 rounded-xl border-Primary p-2">
                        </div>
                    </div>
                </div>`;

                addressMainCon.innerHTML += newAddress;

                if (currentCount + 1 == 4) {
                    document.getElementById("butAd").style.display = 'none';
                }

                updateDeleteLinks();
            }
        }

        document.getElementById("butAd").addEventListener("click", () => {
            document.getElementById("butAd").style.display = 'none';
        });
    </script>
@endsection
