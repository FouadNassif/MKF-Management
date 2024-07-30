@include('partials.adminSidebar')
<div class="flex items-center justify-center min-h-screen">
    <div class="w-full p-8 bg-white rounded-lg">
        <h1 class="text-2xl font-bold text-center">Add Item</h1>

        <form action="{{ route('items.store') }}" method="POST">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" required
                    class="block w-full px-3 py-2 mt-1 border rounded-md">
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" class="block w-full px-3 py-2 mt-1 border rounded-md"></textarea>
            </div>
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="text" name="price" required
                    class="block w-full px-3 py-2 mt-1 border rounded-md">
            </div>
            <div>
                <label for="imageURL" class="block text-sm font-medium text-gray-700">Image URL</label>
                <input type="text" name="imageURL" required
                    class="block w-full px-3 py-2 mt-1 border rounded-md ">
            </div>
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">Category id</label>
                <select name="category id" class="block w-full px-3 py-2 mt-1 border rounded-md">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="w-full px-4 py-2 font-medium text-white rounded-md bg-Primary">
                    Add Item
                </button>
            </div>
        </form>
    </div>
