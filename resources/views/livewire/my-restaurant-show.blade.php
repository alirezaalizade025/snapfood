<div
    class="w-full h-full {{ $status == 'active' ? 'from-green-300 outline-green-600' : 'from-rose-300 outline-rose-600' }} bg-gradient-to-br to-white rounded-xl outline-2 outline-offset-4 outline-dotted p-10 grid md:grid-cols-2 gap-10">
    <div>
        <div class="font-bold text-2xl">
            name
        </div>
        <input wire:model="name" type="text" class="p-3 rounded-xl w-full">
        @error('name')
            <div class="text-red-500 text-sm">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <div class="font-bold text-2xl">
            Restaurant Type
        </div>
        <select wire:model="foodTypeId" class="p-3 rounded-xl w-full cursor-pointer">
            @foreach ($foodTypes as $foodType)
                <option value="{{ $foodType->id }}">
                    {{ $foodType->name }}
            @endforeach
        </select>
        @error('foodTypeId')
            <div class="text-red-500 text-sm">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <div class="font-bold text-2xl">
            Phone number
        </div>
        <input wire:model="phone" type="text" class="p-3 rounded-xl w-full">

    </div>
    <div>
        <div class="font-bold text-2xl">
            Bank Account
        </div>
        <input wire:model="bankAccount" type="text" class="p-3 rounded-xl w-full">
        @error('bankAccount')
            <div class="text-red-500 text-sm">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <div class="font-bold text-2xl">
            Address
        </div>
        <textarea wire:model="address" class="p-3 rounded-xl w-full resize-none"></textarea>
        @error('address')
            <div class="text-red-500 text-sm">{{ $message }}</div>
        @enderror
    </div>
    <div wire:click="changeStatus"
        class="py-3 px-10 text-gray-600 rounded-xl flex w-1/2 h-1/2 font-bold text-2xl justify-center items-center m-auto cursor-pointer {{ $status == 'active' ? 'bg-green-400' : 'bg-yellow-500' }}">
        {{ $status }}</div>
    <div class="flex justify-end items-end">
        <div wire:click="updateRestaurant"
            class="p-3 bg-indigo-400 text-white rounded-xl text-center cursor-pointer hover:bg-indigo-500">save</div>
    </div>
</div>
