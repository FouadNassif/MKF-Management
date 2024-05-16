<div class="mt-5 w-3/4">
    <label for="address" class="text-Primary font-medium text-xl">Address 1</label>
    @error('address1')
        <span class="text-red-600 font-bold ml-5">*{{ $message }}</span>
    @enderror
    <input type="text" id="address1" name="address1" value="{{Address::where('user_id', Auth::user()->id)->get('address1')}}"
        class="w-full bg-transparent outline-0 cursor-pointer mt-4 border-2 rounded-xl border-Primary p-2">
</div>