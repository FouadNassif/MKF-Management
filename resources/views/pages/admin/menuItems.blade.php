@include('partials.adminSidebar')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Items</h1>
    <a href="{{ route('pages.admin.addItems') }}" class="text-gray-100 p-2 rounded-lg bg-Secondary"> Add items </a>
    <div class="flex flex-wrap mx-4">
        @foreach ($items as $item)
            <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-4">
                <div class="bg-white rounded-lg overflow-hidden">
                    <img src="{{ $item->imageURL }}" alt="" class="w-full h-48 ">
                    <div class="p-4">
                        <h2 class="text-xl text-gray-600 font-semibold">{{ $item->name }}</h2>
                        <p class="mt-2 text-gray-600">{{ $item->description }}</p>
                        <p class="mt-1 text-Secondary font-bold">{{ $item->price }}$</p>
                        <div class="py-3 px-3 text-left"> 
                            <form action="{{ route('item.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-100 p-1 bg-red-600">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
