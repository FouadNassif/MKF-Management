@props(['item'])
<div class='p-2 rounded-xl border-2 border-black w-96 m-5 h-fit'>
    <h1>{{$item->id}}</h1>
    <img src='{{$item->imageURL ? asset('storage/itemImage/'. $item->imageURL) : asset('assets/img/burger.jpeg')}}'>
    <h1 class='font-bold text-xl'>{{ $item->name }}</h1>
    <p class='text-gray-400'>{{ $item->description }}</p>
    <div class='flex justify-between px-2 mt-3'>
        <button class='bg-Primary p-1 text-white rounded-lg w-1/4'>ADD</button>
        <p>${{ $item->price }}</p>
    </div>
</div>
