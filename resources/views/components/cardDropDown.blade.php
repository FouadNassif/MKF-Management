@props(['extended' => 0, 'compressedStyles' => '', 'extendedStyles' => '', 'wrapperStyles' => ""])
<div class="{{$wrapperStyles}} drop_down_card min-w-[100px] border-2 border-Primary rounded-xl px-8 py-4"
    data-extended="{{ $extended }}">
    <div class="flex flex-col justify-between ">
        <div class="{{$extendedStyles}}">
            {{ $slot }}
        </div>
        <button class="self-end mt-4"><img class="w-7 h-7" src="{{ asset('assets/svg/ArrowUp.svg') }}"
                alt="arrow up"></button>
    </div>
    <div class="flex justify-between ">
        <div class="{{$compressedStyles}}">
            {{ $compressed }}
        </div>
        <button><img class="w-7 h-7 rotate-180" src="{{ asset('assets/svg/ArrowUp.svg') }}" alt="arrow down"></button>
    </div>
</div>
