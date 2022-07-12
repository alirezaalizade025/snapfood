<div class="space-y-1 p-2">
    @auth
        @if ($carts->count() && isset($carts['foods']) && count($carts['foods']))
            @foreach ($carts['foods'] as $food)
                <div
                    class="border p-4 bg-gradient-to-r from-white to-emerald-50 drop-shadow-md grid grid-cols-6 gap-2 text-center @if ($loop->first) rounded-t-xl @endif">
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
                    <div class="col-span-2 text-right font-bold line-through">{{ $food->price }} $</div>
                    <div class="col-span-2 text-right font-bold">{{ $food->final_price }} $</div>
                </div>
            @endforeach
            <div
                class="border font-bold py-2 px-4 bg-gradient-to-r from-sky-400 to-blue-50 drop-shadow-md grid grid-cols-10 text-center rounded-b-xl">
                <div class="font-bold text-md col-span-2 text-left text-white">Total</div>
                <div class="col-span-3 text-white">{{ $total_count }}</div>
                <div class="col-span-2 text-blue-700 line-through">{{ $total_price }} $</div>
                <div class="col-span-3 text-right text-blue-700">{{ $total_final_price }} $</div>
            </div>
            <div>
                <div class=" font-black">
                    <div class="flex justify-between">
                        <div class="text-md">Delivery</div>
                        <div class="text-sm">{{ $restaurant->delivery_fee }} $</div>
                    </div>
                    <div class="flex justify-between">
                        <div class="text-md">Total</div>
                        <div class="text-sm">{{ $total_final_price + $restaurant->delivery_fee }} $</div>
                    </div>
                </div>
            </div>
            @auth
                <div class="px-5 pt-3 w-full">
                    {{-- button for sent to checkout page --}}
                    <a href="{{ route('payment.show', $carts['id']) }}">
                        <div
                            class="w-full text-center bg-gradient-to-r from-cyan-500 to-cyan-50 p-3 rounded hover:outline outline-cyan-400 outline-offset-2 font-bold text-white border transition duration-300 hover:scale-105">
                            Payment
                        </div>
                    </a>
                </div>
            @endauth
        @endif
    @endauth
    @guest
        <div class="text-center col-span-2 mt-5 hover:scale-105 transition duration-300">
            <a href="{{ route('login') }}"
                class="text-2xl font-black bg-gradient-to-r from-indigo-200 via-purple-200 to-pink-200 p-3 rounded-xl drop-shadow-lg border text-gradiant-to">Please
                login to order
            </a>
        </div>
    @endguest
</div>
