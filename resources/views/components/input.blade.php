@props(['name', 'type' => 'text'])

<div class="mt-5">
    <label for="{{ $name }}" class="text-Primary font-medium">{{ ucfirst($name) }}</label>
    @error($name)
        <span class="text-red-600 font-bold ml-5">*{{ $message }}</span>
    @enderror
    <br>
    <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ old($name) }}"
        class="w-full bg-transparent outline-0 cursor-pointer mt-4 border-b-2 border-Primary">
</div>