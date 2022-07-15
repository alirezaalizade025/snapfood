<div>
    <div class="flex justify-between items-center my-5">
        <div class="my-2">
            <input wire:model.debounce.500ms="search" type="text" class="rounded-full drop-shadow-xl p-3"
                placeholder="search code">
        </div>
        <div class="flex gap-5 rounded-full backdrop-blur-lg bg-teal-500/10 p-2 select-none drop-shadow-xl">
            <label for="investigation">
                <input id="investigation" type="checkbox" value="1" wire:click="filterStatus('1')"
                    class="peer hidden" @checked(in_array('1', $status))>
                <div
                    class="bg-gradient-to-r peer-checked:from-indigo-400 peer-checked:to-teal-400 peer-checked:text-white peer-checked:font-black transition duration-150 p-2 rounded-full drop-shadow-xl cursor-pointer hover:scale-95 hover:translate-y-[0.125rem] peer-checked:outline outline-white">
                    Ivestigation
                </div>
            </label>
            <label for="prepering">
                <input id="prepering" type="checkbox" value="2" wire:click="filterStatus('2')" class="peer hidden">
                <div
                    class="bg-gradient-to-r peer-checked:from-indigo-400 peer-checked:to-teal-400 peer-checked:text-white peer-checked:font-black transition duration-150 p-2 rounded-full drop-shadow-xl cursor-pointer hover:scale-95 hover:translate-y-[0.125rem] peer-checked:outline outline-white">
                    Perepring
                </div>
            </label>
            <label for="sending">
                <input id="sending" type="checkbox" value="3" wire:click="filterStatus('3')" class="peer hidden">
                <div
                    class="bg-gradient-to-r peer-checked:from-indigo-400 peer-checked:to-teal-400 peer-checked:text-white peer-checked:font-black transition duration-150 p-2 rounded-full drop-shadow-xl cursor-pointer hover:scale-95 hover:translate-y-[0.125rem] peer-checked:outline outline-white">
                    sending
                </div>
            </label>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-5">
        @foreach ($carts as $cart)
            <div class="bg-gradient-to-br from-[#fdd8dd] to-[#ddfff7] rounded-xl border drop-shadow-lg p-5">
                <div class="flex justify-between gap-2">
                    <div class="font-bold text-xl">#{{ $cart->id }}</div>
                    <div class="bg-blue-200 p-1 rounded-xl shadow-lg shadow-blue-700/80">
                        create:{{ $cart->created_at->diffForHumans() }}</div>
                    <div class="bg-pink-200 p-1 rounded-xl shadow-lg shadow-pink-700/80">last action:
                        {{ $cart->updated_at->diffForHumans() }}</div>
                </div>
                <div>
                    <div class="text-black font-bold my-8" aria-label="Breadcrumb">
                        <div class="list-none p-0 inline-flex capitalize">
                            <div class="flex items-center">
                                <div wire:click="changeStatus({{ $cart->id }}, 1)"
                                    class="hover:text-indigo-600 hover:scale-110 cursor-pointer transition duration-200 rounded-lg p-1 @if ($cart->status == 1) bg-indigo-400 text-white @endif">
                                    investigating</div>
                            </div>
                            <div class="flex items-center">
                                <span class="mx-2">></span>
                                <div wire:click="changeStatus({{ $cart->id }}, 2)"
                                    class="hover:text-indigo-600 hover:scale-110 cursor-pointer transition duration-200 rounded-lg p-1 @if ($cart->status == 2) bg-indigo-400 text-white @endif">
                                    prepering</div>
                            </div>
                            <div class="flex items-center">
                                <span class="mx-2">></span>
                                <div wire:click="changeStatus({{ $cart->id }}, 3)"
                                    class="hover:text-indigo-600 hover:scale-110 cursor-pointer transition duration-200 rounded-lg p-1 @if ($cart->status == 3) bg-indigo-400 text-white @endif">
                                    sending</div>
                            </div>
                            <div class="flex items-center">
                                <span class="mx-2">></span>
                                <div wire:click="changeStatus({{ $cart->id }}, 4)"
                                    class="hover:text-indigo-600 hover:scale-110 cursor-pointer transition duration-200 rounded-lg p-1 @if ($cart->status == 4) bg-indigo-400 text-white @endif">
                                    delivered
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-300 rounded-xl p-2 mb-3">
                    {{ $cart->user->addresses()->where('is_current_location', 1)->get()->first()->address }}</div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="font-bold border-b border-black">Food</div>
                    <div class="font-bold border-b border-black">Quantity</div>
                    @foreach ($cart->food as $food)
                        <div>{{ $food->food->name }}</div>
                        <div>{{ $food->quantity }}</div>
                    @endforeach
                    <div class="font-bold border-t border-indigo-500">Total</div>
                    <div class="font-bold border-t border-indigo-500">{{ $cart->final_price }} $</div>
                </div>
            </div>
        @endforeach
    </div>
</div>
