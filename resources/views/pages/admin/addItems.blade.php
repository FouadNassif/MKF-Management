@include('partials.adminSidebar')
<div class="flex items-center justify-center min-h-screen w-full align-center">
    <div class="w-full px-8 flex justify-center">
        <div>
            <h1 class="text-2xl font-bold text-center">Add Item</h1>
            <form action="{{ route('items.store') }}" method="POST">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" required id="nameInput"
                        class="block w-full px-3 py-2 mt-1 border rounded-md border-gray-300">
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" class="block w-full px-3 py-2 mt-1 border rounded-md border-gray-300" id="descriptionInput"></textarea>
                </div>
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="text" name="price" required id="priceInput"
                        class="block w-full px-3 py-2 mt-1 border rounded-md border-gray-300">
                </div>
                <div>
                    <label for="imageURL" class="block text-sm font-medium text-gray-700">Image URL</label>
                    <input type="text" name="imageURL" required id="imageUrlInput"
                        class="block w-full px-3 py-2 mt-1 border rounded-md border-gray-300">
                </div>
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Category id</label>
                    <select name="category" class="block w-full px-3 py-2 mt-1 border rounded-md border-gray-300" id="categoryInput">
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

        <div>
            <div class='p-2 rounded-xl border-2 border-black w-96 m-5 min-h-90 max-h-90 '>
                <img src='' id="item_img">
                <h1 class='font-bold text-xl' id="item_name"></h1>
                <p class='text-gray-400 min-h-24 max-h-24 overflow-hidden text-ellipsis' id="item_description"></p>
                <div class='flex justify-between px-2 mt-3'>
                    <button class='bg-Primary p-1 text-white rounded-lg w-1/4'>ADD</button>
                    <p id="item_price"></p>
                </div>
            </div>
        </div>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('nameInput');
            const descriptionInput = document.getElementById('descriptionInput');
            const priceInput = document.getElementById('priceInput');
            const imageUrlInput = document.getElementById('imageUrlInput');
            
            const itemName = document.getElementById('item_name');
            const itemDescription = document.getElementById('item_description');
            const itemPrice = document.getElementById('item_price');
            const itemImg = document.getElementById('item_img');

            nameInput.addEventListener('input', function() {
                itemName.textContent = nameInput.value;
            });

            descriptionInput.addEventListener('input', function() {
                itemDescription.textContent = descriptionInput.value;
            });

            priceInput.addEventListener('input', function() {
                itemPrice.textContent = `$${priceInput.value}`;
            });

            imageUrlInput.addEventListener('input', function() {
                itemImg.src = imageUrlInput.value;
            });
        });
    </script>
</div>
