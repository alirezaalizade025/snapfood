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
        <input wire:model.debounce.500ms="search" wire:change="getRestaurants" type="text" placeholder="search restaurant" class="input input-bordered input-warning  w-full max-w-xs" />
    </div>
    @foreach ($restaurants as $restaurant)
        <div
            class="card bg-base-100 shadow-xl shadow-yellow-800/70 image-full h-64 hover:-translate-y-2 hover:outline-dashed outline-offset-4 transition duration-300">
            <figure><img src="{{ optional($restaurant->image)->path }}" alt="Shoes"
                    class="object-cover w-full max-h-64" />
            </figure>
            <div class="card-body">
                <h2 class="card-title">{{ $restaurant->title }}</h2>
                <div class="rating rating-sm flex gap-5">
                    <div>
                        @for ($i = 1; $i <= 5; $i++)
                            <input type="radio" name="rating-{{ $restaurant->id }}"
                                class="mask mask-star-2 bg-orange-400" @checked($i == round($restaurant->score)) />
                        @endfor
                    </div>
                    {{ number_format($restaurant->score, 2) }}
                </div>
                {{ $restaurant->category->implode('name', ', ') }}
                <div class="mt-auto">
                    <div class="backdrop-blur-sm bg-white/30 p-1 rounded-full flex justify-center">Send cost:
                        <span>
                            10000
                            {{-- TODO:send cost add to db and myrestaurant show --}}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="w-full mt-10 flex justify-center items-center">
        {{ $restaurants->links() }}
    </div>
</div>
