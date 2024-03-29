<form wire:submit.prevent="editType">
    <x-jet-dialog-modal wire:model="showingModal">
        <x-slot name="title">
            {{ $title }}
        </x-slot>


        <x-slot name="content">
            <section class="max-w-[100rem] p-6 pb-10 mx-auto bg-sky-200 rounded-md shadow-md dark:bg-gray-800">
                <form>
                    <div class="grid  gap-6 mt-4">
                        <div>
                            <label class="text-black dark:text-gray-200" for="username">Name</label>
                            <input id="username" type="text" wire:model="name"
                                class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                            @error('name')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </form>
                <div class="mt-4">
                    <div>
                        <label class="text-black dark:text-gray-200" for="username">Category</label>
                        <select wire:model="subCategory"
                            class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                            <option value="main">main</option>
                            @forelse ($mainCategories as $mainCategory)
                                <option value="{{ $mainCategory->id }}">{{ $mainCategory->name }}</option>
                            @empty
                                <option value="">No main category</option>
                            @endforelse
                        </select>
                    </div>
                </div>
        </x-slot>


        <x-slot name="footer">
            <div class="flex gap-5 justify-center font-bold text-black">
                <div class="p-2 rounded bg-red-400 cursor-pointer" wire:click="$set('showingModal', false)">Cancel
                </div>
                <button class="p-2 rounded bg-sky-500 cursor-pointer">update</button>
            </div>
        </x-slot>

    </x-jet-dialog-modal>
    </div>
