<x-app-layout>
    <div>
        <div
            class="w-full min-h-[calc(100vh-4rem)] p-8 border bg-gradient-to-r from-[#dbd5ed] to-[#f3e7ea] text-stone-800 pb-20">
            <h2 class="text-[#ab6299] text-3xl font-black">Reports</h2>
            <div class="flex justify-center mt-10">
                <div class="w-full">
                    @livewire('dashboard.restaurant.reports.show-reports')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
