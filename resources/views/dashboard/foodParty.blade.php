<x-app-layout>
    <div>
        <div class="bg-lime-100 w-full h-full p-8 border bg-gradient-to-r from-lime-200 text-lime-800 pb-20">
            <div class="flex justify-between">
                <h3 class="font-black text-2xl mb-4">Food Party</h3>
                <div onclick="Livewire.emit('showAddFoodModal')"
                    class="bg-lime-400 px-5 py-3 font-extrabold text-white text-4xl rounded-3xl shadow-lg transition duration-200 hover:shadow-none cursor-pointer shadow-lime-800/80">
                    +
                </div>
            </div>
            <div class="px-10 py-5">
                <livewire:food-party-table />
            </div>
            <div class="mt-5">
            </div>
        </div>

        <livewire:modal-add-food />
    </div>
</x-app-layout>
