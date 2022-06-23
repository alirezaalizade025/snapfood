<div>
    <form wire:submit.prevent="{{ $componentType }}Type" class="flex gap-5 w-full">
        <x-jet-input type="text" class="w-1/2 p-2 shadow-lg shadow-cyan-800/90" wire:model.debounce.500ms="name"
            placeholder="Enter restaurant type" />
        <x-jet-button
            class="capitalize bg-green-500 text-white hover:bg-green-600 focus:bg-green-400 shadow-lg shadow-green-800/90 hover:shadow-none">
            {{ $componentType }}
        </x-jet-button>

        @error('name')
            <div class="text-red-500 text-sm self-center">{{ $message }}</div>
        @enderror
    </form>
</div>
