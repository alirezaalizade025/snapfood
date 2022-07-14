<x-app-layout>
    <div>
        <div
            class="w-full min-h-[calc(100vh-4rem)] p-8 border bg-gradient-to-r from-[#dbd5ed] to-[#f3e7ea] text-stone-800 pb-20">
            <h2 class="text-[#ab6299] text-3xl font-black">Reports</h2>
            <div class="mt-10">
                <div class="w-full">
                    <h1>{{ $chart->options['chart_title'] }}</h1>
                    {!! $chart->renderHtml() !!}
                </div>
                <div class="w-full">
                    @livewire('dashboard.restaurant.reports.show-reports')
                </div>
            </div>
        </div>
    </div>
    {!! $chart->renderChartJsLibrary() !!}
    {!! $chart->renderJs() !!}
</x-app-layout>
