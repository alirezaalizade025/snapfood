<x-app-layout>
    <div>
        <div
            class="min-h-[calc(100vh-4rem)] bg-rose-50 w-full p-8 border bg-gradient-to-r from-neutral-400-200 text-black pb-20">
            <h3 class="font-black text-2xl my-4">My Resturant</h3>
            <div
                class="bg-gradient-to-t from-teal-100 mt-5 mx-auto p-10 rounded-xl outline-2 outline-sky-300 outline-offset-4 outline-dotted">
                <livewire:select-schedule />
            </div>
            <div
                class="bg-gradient-to-l from-sky-100 mt-5 mx-auto p-10 rounded-xl outline-2 outline-sky-300 outline-offset-4 outline-dotted">
                @php
                    $location = ['lat' => $restaurantInfo->addressInfo->latitude ?? 37.26075, 'long' => $restaurantInfo->addressInfo->longitude ?? 49.944727];
                @endphp
                <x-maps-leaflet :centerPoint="$location" :zoomLevel="10" :markers="[$location]"
                    style="height:20rem;width:20rem;border-radius:5px; margin: auto; z-index:5">
                </x-maps-leaflet>
            </div>
            <div class="mt-5">
                <livewire:my-restaurant-show class="mt-5" />
            </div>

        </div>
    </div>
</x-app-layout>
