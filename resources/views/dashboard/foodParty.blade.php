<x-app-layout>
    <div>
        <div class="min-h-[calc(100vh-4rem)] w-full p-8 border bg-gradient-to-br from-lime-200 to-lime-50 text-lime-800 pb-20">
            <div class="flex justify-between">
                <h3 class="font-black text-2xl mb-4">Food Party</h3>
                <div onclick="Livewire.emit('showAddFoodModal')"
                    class="bg-lime-400 px-5 py-3 font-extrabold text-white text-4xl rounded-3xl shadow-lg transition duration-200 hover:shadow-none cursor-pointer shadow-lime-800/80">
                    +
                </div>
            </div>
            <div class="px-10 py-5">
                <livewire:dashboard.admin.food-party.food-party-table />
            </div>
            <div class="mt-5">
            </div>
        </div>

        <livewire:dashboard.admin.food-party.modal-add-food-party />
    </div>
</x-app-layout>
