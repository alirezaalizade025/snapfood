<div>
    <x-jet-dialog-modal wire:model="showingModal">
        <x-slot name="title">
            {{ $title }}
        </x-slot>


        <x-slot name="content">
            <section class="max-w-[100rem] p-6 mx-auto bg-indigo-400 rounded-md shadow-md dark:bg-gray-800">
                <form>
                    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                        <div>
                            <label class="text-white dark:text-gray-200" for="username">Name</label>
                            <input id="username" type="text" wire:model="name"
                                class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                            @error('name')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-white dark:text-gray-200" for="price">Price</label>
                            <input wire:model="price" wire:change="finalPrice" id="price" type="text"
                                class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                            @error('price')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="text-white dark:text-gray-200" for="discount">Discount</label>
                            <input id="discount" type="text" wire:model="discount" wire:change="finalPrice"
                                class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                            @error('discount')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="text-white dark:text-gray-200" for="passwordConfirmation">Food party</label>
                            <select wire:model="foodParty.id" wire:change="finalPrice"
                                class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                                <option>None</option>
                                @foreach ($foodParties as $item)
                                    <option value="{{ $item->id }}"">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('food_party_id')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="text-white dark:text-gray-200" for="passwordConfirmation">Food type</label>
                            <select wire:model="foodType.id"
                                class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                                <option>None</option>
                                @foreach ($foodTypes as $item)
                                    <option value="{{ $item->id }}"">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('food_type_id')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- TODO:row material --}}
                        <div>
                            <label class="text-white dark:text-gray-200" for="passwordConfirmation">FinalPrice</label>
                            <div
                                class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                                {{ $finalPrice }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-white">
                                Image
                            </label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-white" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="file-upload"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span class="">Upload a file</span>
                                            <input id="file-upload" name="file-upload" type="file" class="sr-only">
                                        </label>
                                        <p class="pl-1 text-white">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-white">
                                        PNG, JPG, GIF up to 10MB
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
        </x-slot>


        <x-slot name="footer">
            <div class="flex gap-5 justify-center font-bold text-white">
                <div class="p-2 rounded bg-red-400 cursor-pointer" wire:click="$set('showingModal', false)">Cancel
                </div>
                <div class="p-2 rounded bg-indigo-500 cursor-pointer" wire:click="storeFood">save</div>
            </div>
        </x-slot>

    </x-jet-dialog-modal>
</div>
