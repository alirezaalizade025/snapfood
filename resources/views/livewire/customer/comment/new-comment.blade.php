<div class="w-full">
    <div class="w-full flex px-5 justify-between items-center">
        <select wire:model="cart" class="select select-bordered w-full max-w-xs">
            <option value="null" selected>Select on of your carts?</option>
            @foreach ($uncommentedCarts as $cart)
                <option value="{{ $cart->id }}">{{ $cart->id . ' - ' . $cart->created_at . ' - ' . $cart->restaurant->title }}</option>
            @endforeach
        </select>
        <div class="rating">
            <input type="radio" wire:model="newRating" value="1" class="mask mask-star-2 bg-yellow-400" />
            <input type="radio" wire:model="newRating" value="2" class="mask mask-star-2 bg-yellow-400" />
            <input type="radio" wire:model="newRating" value="3" class="mask mask-star-2 bg-yellow-400" />
            <input type="radio" wire:model="newRating" value="4" class="mask mask-star-2 bg-yellow-400" />
            <input type="radio" wire:model="newRating" value="5" class="mask mask-star-2 bg-yellow-400" />
            <span class="mx-2 text-yellow-500">{{ $newRating }}</span>
        </div>
    </div>
    <div class="w-full flex gap-3">
        <textarea wire:model="newComment" type="text"
            class="py-1 px-3 mx-2 my-2 rounded-3xl bg-gradient-to-r from-[#fff5f5] to-white w-full border border-rose-400 shadow-md shadow-rose-700/80 text-rose-700">
    </textarea>
        <button wire:click="addComment"
            class="bg-rose-200 border border-rose-700 rounded-xl text-rose-700 p-3 self-center hover:scale-90 transition duration-200 focus:scale-110 shadow-md shadow-rose-700/80 hover:shadow-inner">
            submit
        </button>
    </div>
    @error('newComment')
        <div class="text-red-500 text-sm text-center">{{ $message }}</div>
    @enderror
</div>
