@props(['id', 'items'])
<div class="my-5 flex justify-between border-2 rounded-xl border-Primary p-5 w-full">
    <p>{{$id}}</p>
    <p>{{$items}}</p>
    <p><button class="mx-5" onclick="expandOrder(1)"><img class=" w-8 rotate-180"
        src="{{ asset('assets/svg/ArrowUp.svg') }}" alt=""></button></p>
</div>