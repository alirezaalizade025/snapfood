<div class="w-fill h-full bg-gradient-to-r from-[#9fc3ed] to-[#bdeddd] p-10">
    <div class="grid lg:grid-cols-2 gap-2 group">
        @isset($categories)
            @foreach ($categories as $category)
                <div class="col-span-full text-center font-bold">
                    <div
                        class="bg-gradient-to-b rounded-t-xl from-slate-300 to-slate-100 w-1/3 group-hover:w-full border transition-all duration-300 m-auto">
                        {{ $category->title }}
                    </div>
                </div>
                @foreach ($category->foods as $food)
                    <div class="bg-gradient-to-b from-[#96d2de] to-sky-100 border rounded-xl overflow-auto drop-shadow-xl">
                        <div class="flex h-full">
                            <div class="self-center">
                                @isset($food->image)
                                    <img src="{{ asset('storage/photos/food/' . $food->image) }}"
                                        class="object-cover w-32 h-32 rounded-xl">
                                @else
                                    <img src="https://tailus.io/sources/blocks/food-delivery/preview/images/icon.png"
                                        class="object-cover max-w-[8rem] max-h-[8rem] p-1 border-r">
                                @endisset
                            </div>
                            <div class="flex-grow text-center">
                                <span class=" p-2 font-bold text-lg">{{ $food->title }}</span>
                                <div>
                                    {{ $food->raw_material }}
                                </div>
                                @if (isset($food->off))
                                    <div class="flex items-center gap-3 mt-3 px-3">
                                        <div class=" p-2 text-left line-through">{{ $food->price }}$</div>
                                        <div
                                            class="self-center font-bold p-1 border border-[#f18375] text-[#ff6c58] bg-[#f0c9c4]  rounded-full text-sm">
                                            {{ $food->off->label }} off
                                        </div>
                                    </div>
                                @endisset
                                <div class="flex justify-between px-3">
                                    <div class="font-bold rounded-xl p-2 text-green-500">{{ $food->final_price }} $
                                    </div>
                                    @Auth
                                        <div class="rounded-full cursor-pointer py-1 px-2 bg-gradient-to-br from-orange-500 to-orange-200 text-white self-center hover:from-sky-500 hover:scale-110 transition duration-200"
                                            wire:click="addToCart({{ $food->id }})">Add</div>
                                    @endauth
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
