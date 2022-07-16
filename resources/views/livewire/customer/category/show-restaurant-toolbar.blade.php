<div class="h-full w-full shadow-2xl shadow-teal-900/30 rounded-lg px-3 py-5">
    <div>
        <h3 class="text-lg font-bold bg-rose-400 rounded-xl p-2 text-white">{{ $category->name }}</h3>
        <div class="flex flex-col gap-1 ml-2 my-5">
            @foreach ($categories as $category)
                <label for="category{{ $category->id }}">
                    <input wire:click="handleSubCategory({{ $category->id }})" type="checkbox"
                        value="{{ $category->id }}" id="category{{ $category->id }}" class="peer hidden">
                    <span
                        class="flex cursor-pointer hover:bg-yellow-200 p-2 px-5 rounded transition-all peer-checked:bg-yellow-300">{{ $category->name }}</span>
                </label>
            @endforeach
        </div>
    </div>
</div>
