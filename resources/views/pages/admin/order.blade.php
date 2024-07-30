@include('partials.adminSidebar')
<div class=" mx-40 p-4">
    <h1 class="text-xl">All Orders</h1>
    <table class="min-w-full bg-white border-rounded">
        <thead>
            <tr class="bg-Secondary text-gray-100 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left"> Order id</th>
                <th class="py-3 px-6 text-left">Cashier id</th>
                <th class="py-3 px-6 text-left">Customer id</th>
                <th class="py-3 px-6 text-left">Waiter id</th>
                <th class="py-3 px-6 text-left">Driver id</th>
                <th class="py-3 px-6 text-left">Total</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            @foreach($orders as $order)
                <tr class="border-b hover:bg-gray-100">
                    <td class="py-3 px-6 text-left">{{ $order->id }}</td>
                    <td class="py-3 px-6 text-left">{{ $order->cashier_id }}</td>
                    <td class="py-3 px-6 text-left">{{ $order->customer_id }}</td>
                    <td class="py-3 px-6 text-left">{{ $order->waiter_id }}</td>
                    <td class="py-3 px-6 text-left">{{ $order->driver_id }}</td>
                    <td class="py-3 px-6 text-left">{{ $order->total }}$</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

