@include('partials.adminSidebar')
<div class=" mx-40 p-4">
    <h1 class="text-xl">All Waiters</h1>
    <table class="min-w-full bg-white border-rounded">
        <thead>
            <tr class="bg-Secondary text-gray-100 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">ID</th>
                <th class="py-3 px-6 text-left">Name</th>
                <th class="py-3 px-6 text-left">Phone Number</th>
                <th class="py-3 px-6 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            @foreach($waiters as $waiter)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $waiter->id }}</td>
                    <td class="py-3 px-6 text-left">{{ $waiter->name }}</td>
                    <td class="py-3 px-6 text-left">{{ $waiter->phoneNumber }}</td>
                    <td class="py-3 px-6 text-left">
                        <form action="{{ route('waiter.destroy', $waiter->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-100 p-1 bg-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

