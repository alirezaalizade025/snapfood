<div class="space-y-5">
    <div>
        <select wire:model="selectedFood" class="rounded-xl bg-white p-3">
            <option>all</option>
            @foreach ($foods as $food)
                <option value="{{ $food->id }}">{{ $food->name }}</option>
            @endforeach
        </select>
    </div>
    @foreach ($comments as $comment)
        <div class="bg-white w-full rounded-xl p-5 drop-shadow-2xl flex gap-5">
            <div class="border-r border-sky-400 pr-3 flex flex-col w-56 pb-1 items-center">
                <div class="bg-gray-200 rounded p-2">{{ collect($comment->foods)->implode(', ') }}</div>
                <div class="mt-3">{{ $comment->created_at }}</div>
                @if (auth()->user()->role == 'restaurant')
                    <div class="mt-auto mx-auto flex gap-5">
                        <i wire:click="banComment({{ $comment->id }})"
                            class="fa-solid fa-ban text-2xl font-bold text-red-500 hover:scale-125 hover:drop-shadow-2xl cursor-pointer">
                        </i>
                        <div class="text-sm text-red-400 font-bold rounded self-center">
                            {{ $comment->delete_request ? 'Requested' : null }}
                        </div>
                    </div>
                @else
                    <div class="mt-auto mx-auto flex gap-5">
                        <i wire:click="deleteComment({{ $comment->id }})"
                            class="fa-solid fa-trash text-2xl font-bold text-red-500 hover:scale-125 hover:drop-shadow-2xl cursor-pointer"></i>
                    </div>
                @endif
            </div>
            <div class="w-full">
                <div class="mb-5 flex justify-between items-center">
                    <div class="text-xl font-bold">{{ $comment->author->name }}</div>
                    <div>
                        @foreach (range(1, $comment->score) as $score)
                            <i class="fa-solid fa-star text-yellow-400"></i>
                        @endforeach
                        {{ $score }}
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <div class="px-5">content</div>
                        <div class="w-full h-20 bg-gray-50 rounded-xl p-3 overflow-auto">{{ $comment->content }}</div>
                    </div>
                    @empty($comment->answer)
                        <form wire:submit.prevent="setAnswer(Object.fromEntries(new FormData($event.target)))">
                            <div class="flex justify-between px-5">
                                <div>answer</div>
                                @if (auth()->user()->role == 'restaurant')
                                    <button>
                                        <i
                                            class="fa-solid fa-paper-plane text-lg font-bold text-blue-500 hover:scale-125 hover:drop-shadow-2xl cursor-pointer">
                                        </i>
                                    </button>
                                @endif
                            </div>
                            <textarea name="answer" class="resize-none w-full h-20 bg-gray-50 rounded-xl p-3"></textarea>
                            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                        </form>
                    @else
                        <div>
                            <div class="px-5">answer</div>
                            <div class="w-full h-20 bg-gray-50 rounded-xl p-3 overflow-auto">{{ $comment->answer }}</div>
                        </div>
                    @endempty
                </div>
            </div>
        </div>
    @endforeach
</div>
