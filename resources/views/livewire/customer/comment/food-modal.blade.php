    <x-jet-dialog-modal wire:model="showingModal">
        <x-slot name="title">
            {{ $title }}
        </x-slot>


        <x-slot name="content">
            <div class="flex">
                <div class="space-y-5 w-4/5">
                    <div class="font-black text-lg">{{ $food->name ?? null }}
                        <div>
                            @for ($i = 0; $i < $score; $i++)
                                <i class="fa-solid fa-star text-yellow-400"></i>
                            @endfor
                            {{ $score }}
                        </div>
                    </div>
                    <div>{{ optional(optional($food)->rawMaterials)->implode(', ') ?? null }}</div>
                    <div class="flex gap-5">
                        <div class="bg-rose-100 rounded p-1 border border-rose-400 text-rose-400 self-center">
                            {{ optional(optional($food)->off)['label'] }}</div>
                        <div class="">
                            <div class="text-sm text-gray-400 line-through">{{ optional($food)->price }} $</div>
                            <div>{{ optional($food)->final_price }} $</div>
                        </div>
                    </div>

                </div>
                <div class="w-1/5 flex bg-[#f2f2f2] rounded-xl overflow-hidden">
                    @if (optional($food)->image)
                        <img src="{{ asset('storage/photos/food/' . $food->image->path) }}"
                            class="w-32 h-32 object-cover p-2  ml-auto rounded-xl" alt="">
                    @else
                        <img src="https://tailus.io/sources/blocks/food-delivery/preview/images/icon.png"
                            class="p-2 w-32 h-32 object-cover  ml-auto" alt="">
                    @endif

                </div>
            </div>
            <div class="border-t-4 border-spacing-3 my-5 p-5 flex flex-col gap-5 h-[12rem] overflow-auto .scrollbar">
                @forelse ($comments as $comment)
                    <div class="border-b border-rose-500 pb-5">
                        <div class="flex items-center justify-between">
                            <div class="font-bold">{{ optional(optional($comment)->author)->name }}</div>
                            <div>
                                {{ Carbon\Carbon::parse(optional($comment)->created_at)->diffForHumans() }}
                            </div>
                            <div class="mt-2">
                                @for ($i = 0; $i < optional($comment)->score; $i++)
                                    <i class="fa-solid fa-star text-yellow-400"></i>
                                @endfor
                                {{ optional($comment)->score }}
                            </div>
                        </div>
                        <div class="flex flex-col justify-between">
                            <div>{{ optional($comment)->content }}</div>
                            @if (optional($comment)->answer)
                                <div class="bg-rose-100 rounded-xl m-2 p-2">
                                    <div class="font-bold">replayed:</div> 
                                    {{ optional($comment)->answer }}
                                </div>
                            @endif
                            <div class="flex gap-3">
                                @if (optional($comment)->content)
                                    @forelse (optional($comment)->foods as $food)
                                        <div class="bg-gray-200 rounded-full px-2 py-1">{{ $food }}</div>
                                    @empty
                                        <div class="bg-gray-200 rounded-full px-2 py-1">No foods</div>
                                    @endforelse
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500">
                        No comments yet.
                    </div>
                @endforelse
            </div>
        </x-slot>


        <x-slot name="footer">
            <div class="flex flex-col w-full items-center">
                @if (optional($uncommentedCarts)->count() > 0)
                    @livewire('customer.comment.new-comment', ['food_id' => $food_id])
                @endif
                <button wire:click="$toggle('showingModal')" class="absolute top-1 right-3 text-xl hover:font-bold">
                    &times;
                </button>
            </div>
        </x-slot>

    </x-jet-dialog-modal>
