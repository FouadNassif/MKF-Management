@include('partials.adminSidebar')
<div class=" mx-40 p-4">
    <h1 class="text-xl">All Orders</h1>
    <table class="min-w-full bg-white border-rounded">
        <thead>
            <tr class="bg-Secondary text-gray-100 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left"> Order id</th>
                <th class="py-3 px-6 text-left">Cashier id</th>
                <th class="py-3 px-6 text-left">Total</th>
                <th class="py-3 px-6 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            @foreach($orders as $order)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $order->id }}</td>
                    <td class="py-3 px-6 text-left">{{ $order->cashier_id }}</td>
                    <td class="py-3 px-6 text-left">{{ $order->total }}</td>
                    <td class="py-3 px-6 text-left">Show details</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

