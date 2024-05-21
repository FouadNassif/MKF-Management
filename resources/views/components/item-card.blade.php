@props(['item'])
<div class="p-2 rounded-xl border-2 border-black w-3/12 m-5">
    <img src="{{ asset('assets/img/burger.jpeg') }}" alt="" class="w-fit">
    <h1 class="font-bold text-xl">{{ $item->name }}</h1>
    <p class="text-gray-400">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates explicabo a, ad id quasi
        excepturi ipsam perferendis dolores eligendi facilis vero corrupti architecto iusto earum sint temporibus. Qui
        quibusdam aut soluta repudiandae, numquam illo modi incidunt officia voluptas doloremque dicta!</p>
    <div class="flex justify-between px-2">
        <button class="bg-Primary p-1 text-white rounded-lg w-1/4">ADD</button>
        <p>${{ $item->price }}</p>
    </div>
</div>
