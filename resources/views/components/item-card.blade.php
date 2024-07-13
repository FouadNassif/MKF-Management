@props(['item'])
<div class='p-2 rounded-xl border-2 border-black w-96 m-5 min-h-90 max-h-90 '>
    <img src='{{ $item->imageURL ? $item->imageURL : asset('assets/img/burger.jpeg') }}'>
    <h1 class='font-bold text-xl'>{{ $item->name }}</h1>
    <p class='text-gray-400 min-h-24 max-h-24 overflow-hidden text-ellipsis'>
        {{ $item->description }}</p>
    </p>
    <div class='flex justify-between px-2 mt-3'>
        <button class='bg-Primary p-1 text-white rounded-lg w-1/4' onclick="showItemModal(this)"
            data-itemId="{{ $item->id }}">ADD</button>
        <p>${{ $item->price }}</p>
    </div>
</div>
