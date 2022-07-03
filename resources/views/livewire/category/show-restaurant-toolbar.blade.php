<div class="h-full w-full shadow-2xl shadow-teal-900/30 rounded-lg px-3 py-5">
    <div>
        <h3 class="text-lg font-bold">categories</h3>
        <div class="flex flex-col ml-2 my-5">
            @foreach ($categories as $category)
                <a href="{{ route('category.show', $category->id) }}" class="hover:bg-yellow-200 p-2 rounded transition-all @if(Request::route('id') == $category->id) bg-yellow-300 @endif">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>
    {{-- TODO:add some more filter --}}
</div>
