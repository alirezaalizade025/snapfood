<x-app-layout>
    <div class="bg-cyan-50 w-full min-h-[calc(100vh-4rem)] p-8 border bg-gradient-to-r from-cyan-200 text-blue-800 pb-20">
        <h3 class="font-black text-2xl mb-4">Resturant Type</h3>
        <div class="px-10 py-5">
            <livewire:add-food-type componentType="add" />
        </div>
        <div class="mt-5">
            <livewire:food-types-table class="mt-5" />
        </div>
    </div>
</x-app-layout>
