@extends('components.layout')

@section('title', 'MKF - Driver')

@section('content')
    @include('partials._navbar')
    <main class="flex flex-col gap-[100px] py-[50px]">
        <div class="min-w-[300px] w-10/12 mx-auto flex flex-col gap-4">
            @foreach ($orders as $order)
                @if ($order->driver_id == $auth_id && $order->status === 'Ongoing')
                    @component('components.cardDropDown')
                        @slot('compressed')
                            <div class="">
                                {{ $order->customer['name'] }} | {{ $order->customer['addresses'][0]['address1'] }} |
                                {{ $order->customer['phoneNumber'] }}
                            </div>
                        @endslot
                        @include('components.itemsTable',  ['items' => $order->items, 'total' => $order->total])
                        <table class="mt-8 w-fullborder-collapse">
                            <tbody>
                                <tr class="border-b border-Primary">
                                    <th class="py-2 px-4 text-left text-sm font-semibold">Customer Name:</th>
                                    <td class="py-2 px-4 text-sm">{{ $order->customer['name'] }}</td>
                                </tr>
                                <tr class="border-b border-Primary">
                                    <th class="py-2 px-4 text-left text-sm font-semibold">Customer Address:</th>
                                    <td class="py-2 px-4 text-sm">{{ $order->customer['addresses'][0]['address1'] }}</td>
                                </tr>
                                <tr class="border-b border-Primary">
                                    <th class="py-2 px-4 text-left text-sm font-semibold">Customer Phone Number:</th>
                                    <td class="py-2 px-4 text-sm">{{ $order->customer['phoneNumber'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <form action="/driver/checkout/{{ $order->id }}">
                            <input type="submit" value="Checkout" class="text-white bg-Primary px-4 py-2 mt-8 rounded hover:cursor-pointer" />
                        </form>
                    @endcomponent
                @endif
            @endforeach
        </div>
        <div class="min-w-[300px] w-10/12 mx-auto flex flex-col gap-4">
            @foreach ($orders as $order)
                @if (!isset($order->driver_id) && $order->driver_id != $auth_id && $order->status === 'Ongoing')
                    @component('components.cardDropDown', ['type' => 'danger'])
                        @slot('compressed')
                            <div class="w-full pr-4 flex justify-between">
                                <div class="">
                                    {{ $order->customer['name'] }} | {{ $order->customer['addresses'][0]['address1'] }} |
                                    {{ $order->customer['phoneNumber'] }}
                                </div>
                                <form action="/driver/deliver/{{ $order->id }}">
                                    <input type="submit" value="Take Order" class="text-white bg-Primary px-4 py-2 rounded hover:cursor-pointer" />
                                </form>
                            </div>
                        @endslot
                        @include('components.itemsTable', ['items' => $order->items, 'total' => $order->total])
                        <table class="mt-8 w-fullborder-collapse">
                            <tbody>
                                <tr class="border-b border-Primary">
                                    <th class="py-2 px-4 text-left text-sm font-semibold">Customer Name:</th>
                                    <td class="py-2 px-4 text-sm">{{ $order->customer['name'] }}</td>
                                </tr>
                                <tr class="border-b border-Primary">
                                    <th class="py-2 px-4 text-left text-sm font-semibold">Customer Address:</th>
                                    <td class="py-2 px-4 text-sm">{{ $order->customer['addresses'][0]['address1'] }}</td>
                                </tr>
                                <tr class="border-b border-Primary">
                                    <th class="py-2 px-4 text-left text-sm font-semibold">Customer Phone Number:</th>
                                    <td class="py-2 px-4 text-sm">{{ $order->customer['phoneNumber'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <form action="/driver/deliver/{{ $order->id }}">
                            <input type="submit" value="Take Order" class="text-white bg-Primary px-4 py-2 mt-8 rounded hover:cursor-pointer" />
                        </form>
                    @endcomponent
                @endif
            @endforeach
        </div>
    </main>
    {{-- {{ $orders[0]['items'][0]['item']['name'] }} --}}
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/cardDropDown.js') }}"></script>
@endsection
