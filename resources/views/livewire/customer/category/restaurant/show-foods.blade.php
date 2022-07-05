<div class="w-fill h-full bg-gradient-to-r from-cyan-100 to-cyan-50 p-10">
    <div class="grid lg:grid-cols-2 gap-2">
        @isset($categories)
            @foreach ($categories as $category)
                <div class="col-span-full text-center font-bold">
                    <div
                        class="bg-gradient-to-b rounded-t-xl from-slate-300 to-slate-100 w-1/3 hover:w-full border transition-all duration-300 m-auto">
                        {{ $category->title }}</div>
                </div>
                @foreach ($category as $food)
                    <div class="bg-gradient-to-b from-green-100 to-green-50 border rounded-xl overflow-auto drop-shadow-xl">
                        <div class="flex">
                            @isset($food->image)
                                <img src="{{ optional($food->image)->path }}" class="object-cover w-32 h-32">
                            @else
                                <img src="https://tailus.io/sources/blocks/food-delivery/preview/images/icon.png"
                                    class="object-cover w-32 h-32 p-1 border-r">
                            @endisset
                            <div class="flex-grow text-center">
                                <span class=" p-2 font-bold text-lg">{{ $food->name }}</span>
                                @if (isset($food->food_type_id) || isset($food->discount))
                                    <div class="flex items-center gap-3 mt-3 px-3">
                                        <div class=" p-2 text-left line-through">{{ $food->price }}$</div>
                                        <div class="self-center p-1 bg-rose-500 text-white rounded-full text-sm">
                                            {{ $food->discount }}% off</div>
                                    </div>
                                @endisset
                                <div class="flex justify-between px-3">
                                    <div class="font-bold rounded-xl p-2 text-green-500">{{ $food->final_price }} $
                                    </div>
                                    <div class="rounded-full cursor-pointer py-1 px-2 bg-gradient-to-br from-orange-500 to-orange-200 text-white self-center hover:from-sky-500 hover:scale-110 transition duration-200"
                                        wire:click="addToCart({{ $food->id }})">Add</div>
                                </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="mb-10 col-span-full"></div>
        @endforeach
    @else
        <div class="text-center col-span-2">
            <span class="text-2xl font-black">No foods</span>
        </div>
    @endisset
</div>
</div>
