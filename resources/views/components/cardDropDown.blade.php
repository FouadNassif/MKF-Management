@props(['extended' => 0, 'type' => '', 'compressedStyles' => '', 'extendedStyles' => '', 'wrapperStyles' => ""])
<div class="drop_down_card min-w-[100px] border-2 border-Primary rounded-xl px-8 py-4" data-extended="{{ $extended }} {{$wrapperStyles}} " style="border-color: {{ $type == 'danger' ? 'red' : '' }};">
    <div class="flex flex-col justify-between ">
        <div class="w-full {{$extendedStyles}}">
            {{ $slot }}
        </div>
        <button class="self-end mt-4"><img class="w-7 h-7" src="{{ $type == 'danger' ?  asset('assets/svg/ArrowUpRed.svg') : asset('assets/svg/ArrowUp.svg') }}" alt="arrow up"></button>
    </div>
    <div class="flex justify-between ">
        <div class="w-full {{$compressedStyles}}">
            {{ $compressed }}
        </div>
        <button ><img class="w-7 h-7" src="{{ $type == 'danger' ?  asset('assets/svg/ArrowDownRed.svg') : asset('assets/svg/ArrowDown.svg') }}" alt="arrow down"></button>
    </div>
</div>
