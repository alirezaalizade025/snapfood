<div>
    <x-jet-dialog-modal wire:model="showingModal">
        <x-slot name="title">
            {{ $title }}
        </x-slot>


        <x-slot name="content">
            <section class="max-w-[100rem] p-6 mx-auto bg-indigo-400 rounded-md shadow-md dark:bg-gray-800">
                <form>
                    <div class="grid grid-cols-1 gap-6 mt-4 ">
                        <div>
                            <label class="text-black dark:text-gray-200 mb-10">Start Time</label>
                            <x-datetime-picker placeholder="Start Time" without-tips wire:model="start_at"
                                :min="now()" />
                        </div>
                        <div>
                            <label class="text-black dark:text-gray-200 mb-10">Expire Time</label>
                            <x-datetime-picker placeholder="Expire Time" without-tips wire:model="expires_at"
                                :min="now()" />
                        </div>

                        <div>
                            <label class="text-black dark:text-gray-200" for="username">Name</label>
                            <input id="username" type="text" wire:model="name"
                                class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                            @error('name')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-black dark:text-gray-200" for="discount">Discount (%)</label>
                            <input id="discount" type="text" wire:model="discount"
                                class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                            @error('discount')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                </form>
        </x-slot>


        <x-slot name="footer">
            <div class="flex gap-5 justify-center font-bold text-white">
                <div class="p-2 rounded bg-red-400 cursor-pointer" wire:click="$set('showingModal', false)">Cancel
                </div>
                <div class="p-2 rounded bg-indigo-500 cursor-pointer" wire:click="updateFoodParty">save</div>
            </div>
        </x-slot>

    </x-jet-dialog-modal>
</div>