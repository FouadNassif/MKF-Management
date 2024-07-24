@include('partials.adminSidebar')
<div class=" mx-40 p-4">
    <h1 class="text-xl">All Customers</h1>
    <table class="min-w-full bg-white border-rounded">
        <thead>
            <tr class="bg-Secondary text-gray-100 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">ID</th>
                <th class="py-3 px-6 text-left">Name</th>
                <th class="py-3 px-6 text-left">Phone Number</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            @foreach($customers as $customer)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $customer->id }}</td>
                    <td class="py-3 px-6 text-left">{{ $customer->name }}</td>
                    <td class="py-3 px-6 text-left">{{ $customer->phoneNumber }}</td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

