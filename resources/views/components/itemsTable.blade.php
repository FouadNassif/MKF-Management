@props(['items', 'total' => 0])

<table class="min-w-full border-collapse">
    <thead>
        <tr>
            <th class="py-2 px-4 border-b border-Primary text-left text-sm font-semibold">Item Name</th>
            <th class="py-2 px-4 border-b border-Primary text-left text-sm font-semibold">Quantity</th>
            <th class="py-2 px-4 border-b border-Primary text-left text-sm font-semibold">Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr class="hover:bg-gray-100">
                <td class="py-2 px-4 border-b border-Primary">{{ $item->item['name'] }}</td>
                <td class="py-2 px-4 border-b border-Primary">{{ $item['quantity'] }}</td>
                <td class="py-2 px-4 border-b border-Primary">${{ $item->item['price'] * $item['quantity'] }}</td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td class="py-2 px-4 border-b border-Primary">${{ $total }}</td>
        </tr>
    </tbody>
</table>
