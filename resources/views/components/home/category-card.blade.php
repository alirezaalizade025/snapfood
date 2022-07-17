<h2 class="font-black text-2xl text-rose-800">Categories</h2>
<div class="p-10">
    <div class="grid lg:grid-cols-6 md:grid-cols-3 grid-cols-2 gap-5">
        @foreach ($categories as $category)
            <a href="{{ route('category.show', $category->id) }}"
                class="container-card cursor-pointer shadow-lg shadow-rose-800/80 text-center">
                <span class="z-10 font-bold text-lg text-rose-700">{{ $category->name }}</span>
            </a>
        @endforeach
    </div>
</div>
