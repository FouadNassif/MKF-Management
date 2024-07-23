@include('partials.adminSidebar')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Items</h1>
    <div class="flex flex-wrap -mx-4">
        @foreach ($items as $item)
            <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-4">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ $item->imageURL }}" alt="" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-semibold">{{ $item->title }}</h2>
                        <p class="mt-2 text-gray-600">{{ $item->description }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
