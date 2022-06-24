<x-app-layout>
    <div
        class="bg-cyan-50 w-full min-h-[calc(100vh-4rem)] p-8 border bg-gradient-to-r from-cyan-200 text-blue-800 pb-20">
        <div class="flex justify-between">
            <h3 class="font-black text-2xl mb-4">Food Type</h3>
            <div onclick="Livewire.emit('showAddFoodTypeModal')"
                class="bg-sky-400 px-5 py-3 font-extrabold text-white text-4xl rounded-3xl shadow-lg transition duration-200 hover:shadow-none cursor-pointer shadow-sky-800/80">
                +
            </div>
        </div>
        <div class="px-10 py-5">
            <livewire:food-types-table class="mt-5" />
        </div>
        <div class="mt-5">
        </div>
        <livewire:modal-add-food-type />
        <livewire:modal-edit-food-type />
    </div>
</x-app-layout>
