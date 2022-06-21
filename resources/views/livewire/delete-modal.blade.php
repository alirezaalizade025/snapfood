<div>
    <x-jet-dialog-modal wire:model="showingModal">

        <x-slot name="title">
            {{ $title }}
        </x-slot>

        <x-slot name="content">

            <p class="text-red-500 py-5">Are You sure you want delete <span
                    class="p-2 rounded-xl bg-red-500 text-white font-bold">{{ $item }}</span> From List?</p>

        </x-slot>


        <x-slot name="footer">
            <div class="flex gap-5 justify-center font-bold text-white">
                <div class="p-2 rounded bg-blue-300 cursor-pointer" wire:click="$set('showingModal', false)">Cancel</div>
                <div class="p-2 rounded bg-red-500 cursor-pointer" wire:click="deleteItem">Delete</div>
            </div>
        </x-slot>

    </x-jet-dialog-modal>
</div>
