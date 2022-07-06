<x-app-layout>
    <div
        class="bg-cyan-50 w-full min-h-[calc(100vh-4rem)] p-8 border bg-gradient-to-r from-[#fdd8dd] to-[#ddfff7] pb-20">
        <div class="flex justify-between">
            <h3 class="font-black text-2xl mb-4 text-teal-700">Orders</h3>
            {{-- <div onclick="Livewire.emit('showAddFoodTypeModal')"
                class="bg-sky-400 px-5 py-3 font-extrabold text-white text-4xl rounded-3xl shadow-lg transition duration-200 hover:shadow-none cursor-pointer shadow-sky-800/80">
                +
            </div> --}}
        </div>
        <div class="px-10 py-5">
            <livewire:dashboard.restaurant.orders.orders-show :restaurant="$restaurant" />
        </div>

    </div>
</x-app-layout>
