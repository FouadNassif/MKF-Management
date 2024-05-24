@extends('components.layout')

@section('title', 'MKF - POS - Payment')

@section('scripts')
    <script>
        async function complete() {
            try {
                const token = document
                    .querySelector(`meta[name="csrf-token"]`)
                    .getAttribute("content");

                const response = await fetch("/pos/payment", {
                    method: "POST",
                    body: JSON.stringify({
                        order_id: Number(document.getElementById("order_id").textContent)
                    }),
                    headers: {
                        "X-CSRF-TOKEN": token,
                        "Content-type": "application/json",
                    },
                });

                if (!response.ok) {
                    throw new Error("Payment Failed");
                }
                const updated = await response.json();
                if (updated.status) {
                    window.location.href = "/pos/";
                } else {
                    throw new Error("Payment Failed: Internal Server Error");

                }
            } catch (error) {
                console.error(error)
            }
        }

        function changeChange(ref) {
            const change = document.getElementById("change")
            const total = Number(document.getElementById("total").textContent)

            change.innerHTML = Number(ref.value) - total
        }
    </script>
@endsection

@section('content')
    @include('partials._navbar')
    <main class="w-screen h-screen flex justify-center items-center">
        <div class="p-4 border-2 border-Primary rounded-xl">
            <div class="text-xl" id="order_id">{{ $order->id }}</div>
            <div class="flex mt-4">
                <div
                    class="w-[300px] h-[400px] border border-Primary rounded-xl p-4 overflow-y-auto divide-y-0 divide-Primary">
                    <table class="w-full">
                        <thead class="border-b-2 border-Primary">
                            <tr>
                                <th class="font-normal py-6 text-Primary">Product</th>
                                <th class="font-normal py-6 text-Primary">Price</th>
                                <th class="font-normal py-6 text-Primary">Quantity</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-Primary" id="tableBody">
                            @foreach ($items as $item)
                                <tr>
                                    <td style="text-align: center; padding-top: 16px; padding-bottom: 16px">
                                        {{ $item['item']['name'] }}
                                    </td>
                                    <td style="text-align: center; padding-top: 16px; padding-bottom: 16px">
                                        {{ number_format($item['quantity'] * $item['item']['price'], 2) }}
                                    </td>
                                    <td style="text-align: center; padding-top: 16px; padding-bottom: 16px">
                                        {{ $item['quantity'] }}
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mr-8 ml-20 flex flex-col gap-8">
                    <div class="flex flex-col gap-4">
                        <h1 class="text-3xl">Total: <span id="total">{{ $order['total'] }}</span>$</h1>
                        <label>Received: <input onblur="changeChange(this)"
                                class="border border-Primary rounded-xl ml-2 py-1 px-2" type="number"
                                id="received"></label>
                        <p>Change: <span id="change">0</span>$</p>
                    </div>
                    <div class="flex justify-evenly">
                        <a href="/pos" class="px-4 py-2 bg-Danger rounded-xl text-white text-lg">Cancel</a>
                        <button class="px-4 py-2 bg-Primary rounded-xl text-white text-lg"
                            onclick="complete()">Complete</button>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
