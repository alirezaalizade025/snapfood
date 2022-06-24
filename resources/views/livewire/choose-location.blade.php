<div>
    <x-jet-dialog-modal wire:model="showingModal">
        <x-slot name="title">
            {{ $title ?? 'Map' }}
        </x-slot>


        <x-slot name="content">
            <x-maps-leaflet :centerPoint="['lat' => 37.260768, 'long' => 49.944723]" :zoomLevel="13" :markers="[['lat' => 37.260768, 'long' => 49.944723]]" style="height:40vh"></x-maps-leaflet>
        </x-slot>


        <x-slot name="footer">
            <div class="flex gap-5 justify-center font-bold text-black">
                <div class="p-2 rounded bg-red-400 cursor-pointer" wire:click="$set('showingModal', false)">close
                </div>
            </div>
        </x-slot>

    </x-jet-dialog-modal>
</div>
