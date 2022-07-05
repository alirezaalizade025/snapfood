<div class="space-y-1 p-2">
    @if (count($carts) && isset($carts['foods']) && count($carts['foods']))
        @foreach ($carts['foods'] as $food)
            <div
                class="border p-4 bg-gradient-to-r from-white to-emerald-50 drop-shadow-md grid grid-cols-5 gap-2 text-center @if ($loop->first) rounded-t-xl @endif">
                <div class="font-bold text-md text-left col-span-full">{{ $food->title }}</div>
                <div class="flex justify-between items-center col-span-2">
                    <div wire:click="decreaseCount({{ $food->id }})"
                        class="font-bold text-lg bg-red-400 rounded-full drop-shadow-lg px-2 text-white hover:bg-red-300 cursor-pointer">
                        -</div>
                    <div>{{ $food->count }}</div>
                    <div wire:click="increaseCount({{ $food->id }})"
                        class="font-bold text-lg bg-green-400 rounded-full drop-shadow-lg px-2 text-white hover:bg-green-300 cursor-pointer">
                        +</div>
                </div>
                <div class="col-span-3 text-right font-bold">{{ $food->price }} $</div>
            </div>
        @endforeach
        <div
            class="border font-bold py-2 px-4 bg-gradient-to-r from-sky-400 to-blue-50 drop-shadow-md grid grid-cols-10 text-center rounded-b-xl">
            <div class="font-bold text-md col-span-4 text-left text-white">Toral</div>
            <div class="col-span-2 text-white">{{ $total_count }}</div>
            <div class="col-span-4 text-right text-blue-700">{{ $total_price }} $</div>
        </div>
        <div>
            <div class="flex justify-between items-center">
                <div class="text-left">
                    <div class="font-bold text-md">Delivery</div>
                    {{-- <div class="text-sm">{{ $delivery_price }} $</div> --}}
                </div>
                <div class="text-right">
                    <div class="font-bold text-md">Total</div>
                    {{-- <div class="text-sm">{{ $total_price + $delivery_price }} $</div> --}}
                </div>
            </div>
        </div>
        @auth
            <div class="px-5 pt-3">
                {{-- button for sent to checkout page --}}
                <button
                    class="bg-gradient-to-r from-cyan-500 to-cyan-50 w-full p-3 rounded hover:outline outline-cyan-400 outline-offset-2 font-bold text-white border transition duration-300 hover:scale-105">Payment</button>
            </div>
        @endauth
        @guest
            // Show content if unauthenticated
        @endguest
    @endif
</div>