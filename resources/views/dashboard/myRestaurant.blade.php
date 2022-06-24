<x-app-layout>
    <div>
        <div
            class="min-h-[calc(100vh-4rem)] bg-rose-50 w-full p-8 border bg-gradient-to-r from-neutral-400-200 text-black pb-20">
            <h3 class="font-black text-2xl my-4">My Resturant</h3>
            <div class="mt-5">
                <livewire:my-restaurant-show class="mt-5" />
            </div>
            <div class="-mt-[21.5rem] ml-10">
                @php
                    $location = ['lat' => $restaurantInfo->latitude ?? 37.260750, 'long' => $restaurantInfo->longitude ?? 49.944727];
                @endphp
                <x-maps-leaflet :centerPoint="$location" :zoomLevel="10" :markers="[$location]"
                    style="height:20rem;width:20rem;border-radius:5px">
                </x-maps-leaflet>
            </div>
        </div>
    </div>
</x-app-layout>
