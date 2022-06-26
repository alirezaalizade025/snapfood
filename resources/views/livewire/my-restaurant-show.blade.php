<div
    class="w-full h-full pb-[17rem] {{ isset($restaurant['status']) && $restaurant['status'] == 'active' ? 'from-green-300 outline-green-600' : 'from-rose-200 outline-rose-600' }} bg-gradient-to-br to-white rounded-xl outline-2 outline-offset-4 outline-dotted p-10 grid md:grid-cols-2 gap-10">
    <div>
        <div class="font-bold text-2xl">
            title
        </div>
        <input wire:model="restaurant.title" type="text" class="p-3 rounded-xl w-full">
        @error('restaurant.title')
            <div class="text-red-500 text-sm">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <div class="font-bold text-2xl">
            Restaurant Type
        </div>
        <select wire:model="restaurant.food_type_id" class="p-3 rounded-xl w-full cursor-pointer">
            @foreach ($foodTypes as $foodType)
                <option value="{{ $foodType->id }}">
                    {{ $foodType->name }}
            @endforeach
        </select>
        @error('restaurant.food_type_id')
            <div class="text-red-500 text-sm">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <div class="font-bold text-2xl">
            Phone number
        </div>
        <input wire:model="restaurant.phone" type="text" class="p-3 rounded-xl w-full">
        @error('restaurant.phone')
            <div class="text-red-500 text-sm">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <div class="font-bold text-2xl">
            Bank Account
        </div>
        <input wire:model="restaurant.bank_account" type="text" class="p-3 rounded-xl w-full">
        @error('restaurant.bank_account')
            <div class="text-red-500 text-sm">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <div class="font-bold text-2xl">
            Address
        </div>
        <textarea wire:model="restaurant.address" class="p-3 rounded-xl w-full resize-none"></textarea>
        @error('restaurant.address')
            <div class="text-red-500 text-sm">{{ $message }}</div>
        @enderror
    </div>
    @if ($formType == 'update')
        <div class="flex gap-5 items-center">
            <div wire:click="changeStatus"
                class="py-3 px-10 text-gray-600 rounded-xl flex w-1/2 h-1/2 font-bold text-2xl justify-center items-center m-auto cursor-pointer {{ $restaurant['status'] == 'active' ? 'bg-green-400' : 'bg-yellow-500' }}">
                {{ $restaurant['status'] }}</div>
            <div
                class="py-3 px-10 text-gray-600 rounded-xl flex w-1/2 h-1/2 font-bold text-2xl justify-center items-center m-auto {{ $restaurant['confirm'] == 'accept' ? 'bg-green-400' : ($restaurant['confirm'] == 'waiting' ? 'bg-orange-400' : 'bg-red-400') }}">
                {{ $restaurant['confirm'] }}</div>
        </div>
    @endif

    <div class="flex justify-end items-end">
        <div wire:click="updateRestaurant"
            class="p-3 bg-indigo-400 text-white rounded-xl text-center cursor-pointer hover:bg-indigo-500">save</div>
    </div>
    @error('latitude')
        <span class="text-red-500 text-sm">Restaurant location on map required!</span>
    @enderror
</div>
