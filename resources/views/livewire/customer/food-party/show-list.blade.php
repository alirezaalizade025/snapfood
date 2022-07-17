<div class="p-20 space-y-5">
    @foreach ($foodParties as $item)
        <div class="w-full p-5 rounded-xl bg-white text-cyan-700">
            <div class="font-bold text-xl flex justify-between">
                <div>{{ $item['food_party']['name'] }}</div>
                <div class="text-pink-500"><livewire:count-down :expires_at="$item['food_party']->expires_at"/></div>
                <div class="bg-rose-500 p-2 rounded-xl text-white">{{ $item['food_party']['discount'] }} $ Off</div>
            </div>
            <div class="my-5 flex gap-3 overflow-auto scrollbar">
                @foreach ($item['foods'] as $food)
                    <a href="{{ route('restaurant-food.show', $food->restaurant->id) }}">
                        <div class="flex items-center w-80 shadow-xl rounded-xl p-2 gap-2">
                            <div class="rounded-xl overflow-hidden w-36 h-36 drop-shadow-xl">
                                <img class="w-full object-cover"
                                    src="{{ $food->image ? $food->image->path : 'https://tailus.io/sources/blocks/food-delivery/preview/images/icon.png' }}"
                                    class="w-full" alt="food image">
                            </div>
                            <div class="self-start">
                                <div class="font-bold">
                                    {{ $food->name }}
                                </div>
                                <div class="text-sm">
                                    {{ $food->price * (1 - $item['food_party']['discount'] / 100) }} $
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
