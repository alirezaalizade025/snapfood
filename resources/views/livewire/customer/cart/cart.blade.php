<div class="grid md:grid-cols-2  gap-5 drop-shadow-xl">
    @foreach ($carts as $cart)
        @php
            if ($cart->foods == null) {
                continue;
            }
        @endphp
        <div class="mb-5 text-center bg-gray-300 p-2 rounded-xl">
            <div class="text-xl font-bold">
                {{ $cart->restaurant->title }}
            </div>
            <div
                class="capitalize font-black text-lg grid grid-cols-5 bg-gradient-to-b from-[#c80129] p-3 text-white rounded-t-xl border-b">
                <div>title</div>
                <div>price</div>
                <div>final price</div>
                <div class="col-span-2">count</div>
            </div>
            <div>
                @foreach ($cart->foods as $food)
                    <div
                        class="capitalize grid grid-cols-5 items-center bg-[#f2f4f3] p-3 text-[#49111c] border-b even:bg-[#ffe7cf] @if ($loop->last) rounded-b-xl @endif">
                        <div>{{ $food->title }}</div>
                        <div class="px-2">
                            <div class="space-x-2">
                                <span class="line-through">{{ $food->price }}$</span>
                                <span class="text-red-500">{{ $food->off->label }}</span>
                            </div>
                            <span class="text-teal-600">{{ $food->final_price }}$</span>
                        </div>
                        <div>{{ $food->final_price * $food->count }} $</div>
                        <div class="space-x-4 col-span-2">
                            @if ($cart->status == '0')
                                <span wire:click="decrease({{ $food->id }}, {{ $cart->id }})"
                                    class="bg-red-800 rounded text-white px-2 cursor-pointer">-</span>
                                <span
                                    class="bg-[#ffffff] text-[#75192c] px-2 rounded select-none">{{ $food->count }}</span>
                                <span wire:click="increase({{ $food->id }}, {{ $cart->id }})"
                                    class="bg-green-700 rounded text-white px-2 cursor-pointer">+</span>
                                <i wire:click="remove({{ $cart->id }}, {{ $food->id }})"
                                    class="fa-solid fa-trash-can text-red-500 cursor-pointer"></i>
                            @else
                                <span class="text-[#75192c] px-2 rounded select-none">{{ $food->count }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div
                class="my-1 capitalize font-black text-lg grid grid-cols-4 bg-gradient-to-r drop-shadow-lg border  text-indigo-500 rounded-full border-b items-center">
                <div>total</div>
                <div class="text-sm">delivery {{ $cart->restaurant->delivery_fee }} $</div>
                <div>{{ $cart->total + $cart->restaurant->delivery_fee }} $</div>
                @if ($cart->status == '0')
                    <a href="{{ route('payment.show' , $cart->id) }}">
                        <div
                            class=" bg-gradient-to-l from-cyan-400 p-3 hover:scale-110 transition duration-300 rounded-r-full text-rose-500">
                            payment
                        </div>
                    </a>
                @else
                    <div
                        class=" bg-gradient-to-l from-cyan-400 p-3 hover:scale-110 transition duration-300 rounded-r-full text-rose-500">
                        {{ $cart->status == 1 ? 'Investigating...' : ($cart->status == 2 ? 'prepering...' : ($cart->status == 3 ? 'sending...' : 'delivered')) }}
                    </div>
                @endif
            </div>
            @if ($cart->status != '0')
                <div>
                    <i wire:click="reorder({{ $cart->id }})"
                        class="fa-solid fa-retweet text-xl cursor-pointer hover:scale-125 transition duration-200"></i>
                </div>
            @endif
        </div>
    @endforeach
</div>
