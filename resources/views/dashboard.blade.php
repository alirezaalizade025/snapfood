<x-app-layout>
    @if (auth()->user()->role == 'admin')
        <div class="px-6 pt-6 2xl:container">
            <div class="grid md:grid-cols-2">
                <div>
                    <h1>{{ $cartsChart->options['chart_title'] }}</h1>
                    {!! $cartsChart->renderHtml() !!}
                </div>
                <div>
                    <h1>{{ $usersChart->options['chart_title'] }}</h1>
                    {!! $usersChart->renderHtml() !!}
                </div>
                <div>
                    <h1>{{ $restaurantsChart->options['chart_title'] }}</h1>
                    {!! $restaurantsChart->renderHtml() !!}
                </div>
                <div>
                    <h1>{{ $commentsChart->options['chart_title'] }}</h1>
                    {!! $commentsChart->renderHtml() !!}
                </div>
            </div>
        </div>
        {!! $cartsChart->renderChartJsLibrary() !!}
        {!! $cartsChart->renderJs() !!}
        {!! $usersChart->renderJs() !!}
        {!! $restaurantsChart->renderJs() !!}
        {!! $commentsChart->renderJs() !!}
    @else
    <div class="grid md:grid-cols-3 p-20 gap-5">
        <div class="bg-indigo-500 text-white text-xl font-black rounded-xl p-5 flex justify-between">
            <div>Food</div>
            <div>{{ $totalFood }}</div>    
        </div>
        <div class="bg-rose-500 text-white text-xl font-black rounded-xl p-5 flex justify-between">
            <div>Carts</div>
            <div>{{ $totalCarts }}</div>       
        </div>
        <div class="bg-teal-500 text-white text-xl font-black rounded-xl p-5 flex justify-between">
            <div>Comments</div>
            <div>{{ $totalComments }}</div>  
        </div>
    </div>
    @endif
</x-app-layout>
