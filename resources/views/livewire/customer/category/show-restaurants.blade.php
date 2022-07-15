<div class="grid lg:grid-cols-3 md:grid-cols-2 px-10 gap-5">
    <div class="col-span-3 flex justify-between">
        <label for="">sortBy
            <select wire:model="sortBy" class="select select-warning max-w-xs">
                <option value="title">Title</option>
                <option value="rating">Rating</option>
                <option value="price">Send cost</option>
                <option value="distance">Nearest</option>
            </select>
        </label>
        <input wire:model.debounce.500ms="search" wire:change="getRestaurants" type="text"
            placeholder="search restaurant" class="input input-bordered input-warning  w-full max-w-xs" />
    </div>
    @foreach ($restaurants as $restaurant)
        <a href="{{ route('restaurant-food.show', $restaurant->id) }}"
            class="card bg-base-100 shadow-xl shadow-yellow-800/70 image-full h-64 hover:-translate-y-2 hover:outline-dashed outline-offset-4 transition duration-300">
            <figure>
                @isset($restaurant->image)
                    <img src="{{ optional($restaurant->image)->path }}" alt="Shoes"
                        class="object-cover w-full max-h-64" />
                @else
                    <img src="https://tailus.io/sources/blocks/food-delivery/preview/images/icon.png" alt="Shoes"
                        class="object-cover w-full max-h-64" />
                @endisset
            </figure>
            <div class="card-body">
                <h2 class="card-title">{{ $restaurant->title }}</h2>
                {{ $restaurant->id }}
                <div class="rating rating-sm flex gap-5">
                    <div>
                        @for ($i = 1; $i <= 5; $i++)
                            <input type="radio" name="rating-{{ $restaurant->id }}"
                                class="mask mask-star-2 bg-orange-400" @checked($i == round($restaurant->score)) />
                        @endfor
                    </div>
                    {{ $restaurant->score != null ? number_format($restaurant->score, 2) : 'N/A' }}
                </div>
                <div class="h-16 overflow-auto rounded scrollbar">
                    {{ '#' . $restaurant->category->implode('name', ' #') }}
                </div>
                <div class="mt-auto">
                    <div class="backdrop-blur-sm bg-white/30 p-1 rounded-full flex justify-center gap-2">
                        Send cost: <span>{{ $restaurant->delivery_fee }}</span>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
    <div class="w-full mt-10 flex justify-center items-center col-span-3 gap-5">
        {{ count($restaurants) > 0 ? $restaurants->links() : null }}
    </div>
</div>
