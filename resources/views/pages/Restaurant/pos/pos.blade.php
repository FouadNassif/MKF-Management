@extends('components.layout')

@section('title', 'MKF - POS')

@section('scripts')
    <script src="{{ asset('assets/js/pos.js') }}"></script>
@endsection

@section('content')
    @include('partials._navbar')
    <div class="p-4 flex gap-4 overflow-x-auto" style="height: calc(100vh - 80px)">
        <div class="min-w-[550px] w-[60vw] flex flex-col gap-2">
            {{-- Categories --}}
            <div class="flex gap-4 overflow-x-auto py-2 shrink-0" id="category-cards">

            </div>
            {{-- Items --}}
            <div class=" grid gap-2 grid-cols-2 md:grid-cols-3 xl:grid-cols-4 p-4 overflow-y-auto" id="item-cards">

                {{-- Item Skeletons --}}
                @for ($i = 0; $i < 15; $i++)
                    <div class="p-2 rounded-xl border-2 border-[#649B9255] flex-grow cursor-pointer"
                        onclick="addItemToReceipt(this)" data-id="1">
                        <div class="w-[full] bg-[#649B9255] h-[100px]"> </div>
                        <div class="flex justify-between items-center mt-2">
                            <div class="h-[20px] w-[100px] bg-[#649B9255]"></div>
                            <p class="h-[20px] w-[20px] bg-[#649B9255]"></p>
                        </div>
                    </div>
                @endfor

            </div>
        </div>
        <div class="w-[40vw] min-w-[400px]">
            {{-- Reciept --}}
            <div class="h-[85%] border-2 border-Primary rounded-xl">
                <div class="h-[85%] overflow-y-auto">
                    <table class="w-full">
                        <thead class="border-b-2 border-Primary">
                            <tr>
                                <th class="font-normal py-6 text-Primary">Product</th>
                                <th class="font-normal py-6 text-Primary">Price</th>
                                <th class="font-normal py-6 text-Primary">Quantity</th>
                                <th class="font-normal py-6 text-Primary">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-Primary" id="tableBody">
                            <tr>
                                <td colspan="4" class="text-center text-gray-500">Empty List</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex w-full items-center justify-around h-[15%] text-2xl border-t-2 border-Primary">
                    <div>Total:</div>
                    <div id="total">0$</div>
                </div>
            </div>

            {{-- Action --}}
            <div class="h-[15%] flex items-center justify-evenly">
                <button onclick="resetReceipt()" class="px-4 py-2 bg-Danger rounded-xl text-white text-2xl">Reset</button>
                <button onclick="proceed()" class="px-4 py-2 bg-Primary rounded-xl text-white text-2xl">Proceed</button>
            </div>
        </div>
    </div>

    <x-modal id="checkout">
        <div class="border-2 border-Primary rounded-xl w-[400px]">
            <table class="w-full">
                <thead class="border-b-2 border-Primary">
                    <tr>
                        <th class="font-normal py-6 text-Primary">Product</th>
                        <th class="font-normal py-6 text-Primary">Price</th>
                        <th class="font-normal py-6 text-Primary">Quantity</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-Primary">
                    <tr>
                        <td colspan="4" class="text-center text-gray-500">Empty List</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex items-center justify-evenly mt-8">
            <button class="px-4 py-2 bg-Danger rounded-xl text-white text-xl" onclick="toggleModal()">Cancel</button>
            <button class="px-4 py-2 bg-Primary rounded-xl text-white text-xl" onclick="checkout()">Checkout</button>
        </div>
    </x-modal>
@endsection
