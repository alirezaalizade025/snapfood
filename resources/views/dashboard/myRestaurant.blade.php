<x-app-layout>
    <div>
        <div class="bg-rose-50 w-full h-full p-8 border bg-gradient-to-r from-rose-200 text-black pb-20">
            <h3 class="font-black text-2xl my-4">My Resturant</h3>
            <div class="mt-5">
                <livewire:my-restaurant-show :restaurant="$restaurant" :foodTypes="$foodTypes" class="mt-5" />
            </div>
        </div>
    </div>
</x-app-layout>
