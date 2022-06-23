<x-app-layout>
    <div>
        <div
            class="bg-orange-100 w-full min-h-[calc(100vh-4rem)] p-8 border bg-gradient-to-r from-orange-200 text-stone-800 pb-20">
            <div class="flex justify-between">
                <h3 class="font-black text-2xl mb-4">Foods</h3>
                @if (auth()->user()->role != 'admin')
                    <div onclick="Livewire.emit('showAddFoodModal')"
                        class="bg-orange-400 px-5 py-3 font-extrabold text-white text-4xl rounded-3xl shadow-lg transition duration-200 hover:shadow-none cursor-pointer shadow-orange-800/80">
                        +
                    </div>
                @endif
            </div>
            <div class="px-10 py-5">
                <livewire:food-table class="mt-5" />
            </div>
            <div class="mt-5">
            </div>
        </div>
        <livewire:modal-add-food />
        <livewire:edit-food />
    </div>
</x-app-layout>
