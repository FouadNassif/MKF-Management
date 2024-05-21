@props(['index', 'address'])
<label for="address{{ $index }}" class="text-Primary font-medium text-xl">Address
    {{ $index }}</label>
@error('address' . $index)
    <span class="text-red-600 font-bold ml-5">*{{ $message }}</span>
@enderror
<div class="flex items-center justify-center ">
    <input type="text" id="address{{ $index }}" name="address{{ $index }}" value="{{ $address }}"
        class="w-full bg-transparent outline-0 cursor-pointer mt-4 border-2 rounded-xl border-Primary p-2">
