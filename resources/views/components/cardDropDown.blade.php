@props(['extended' => 0])
<div class="drop_down_card min-w-[100px] border-2 border-Primary rounded-xl px-8 py-4" data-extended="{{ $extended }}">
    <div class="flex flex-col justify-between ">
        <div>
            {{ $slot }}
        </div>
        <button class="self-end mt-4"><img class="w-7 h-7" src="{{ asset('assets/svg/ArrowUp.svg') }}" alt="arrow up"></button>
    </div>
    <div class="flex justify-between ">
        <div>
            {{ $compressed }}
        </div>
        <button ><img class="w-7 h-7" src="{{ asset('assets/svg/ArrowDown.svg') }}" alt="arrow down"></button>
    </div>
</div>
