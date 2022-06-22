<div class="w-full">
    @empty(!session('response'))
        @php
            $class = session('response')['status'] == 'success' ? 'bg-green-500' : 'bg-red-500';
        @endphp
        <div>
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90"
                class="text-sm self-center p-2 rounded text-white {{ $class }}">
                {{ session('response')['message'] }}
            </div>
        </div>
        @endif
        <div>
        </div>
        <div class="flex justify-between w-full items-center mb-1">
            <div class="font-bold">
                Total food parties: {{ $foodParties->total() }}
            </div>
            <input wire:change="fetchData" wire:model.debouns.500ms="search" class="rounded-full p-3 border border-lime-300"
                type="text" placeholder="search...">
        </div>
        <div class="col-span-12 w-full">
            <div class="w-full overflow-auto lg:overflow-visible">
                <table class="w-full text-gray-400 border-separate space-y-6 text-sm">
                    <thead class="bg-lime-500 text-gray-100">
                        <tr>
                            <th class="p-3 rounded">ID</th>
                            <th class="p-3 rounded">Name</th>
                            <th class="p-3 rounded">Discount</th>
                            <th class="p-3 rounded">Updated at</th>
                            <th class="p-3 rounded"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($foodParties as $foodParty)
                            <tr class="bg-lime-50 text-lime-900 text-center">
                                <td class="p-3 rounded">
                                    {{ $foodParty->id }}
                                </td>
                                <td class="p-3 rounded">
                                    <div class="flex justify-center">
                                        <div class="ml-3 self-center font-bold">
                                            {{ $foodParty->name }}
                                        </div>
                                    </div>
                                </td>
                                <td class="p-3 rounded space-y-2">
                                    {{ $foodParty->discount }}%
                                </td>
                                <td class="p-3 text-sm rounded">
                                    {{ $foodParty->updated_at }}
                                </td>
                                <td class="p-3 font-bold rounded flex flex-col gap-2 justify-center items-center">
                                    <div class="flex gap-3">
                                        <div wire:click="$emit('showEditModal', {{ $foodParty->id }})"
                                            class="bg-purple-400 cursor-pointer p-2 rounded text-white">edit</div>
                                        <div wire:click="$emit('showDeleteModal', 'FoodParty', {{ $foodParty->id }})"
                                            class="bg-red-500 cursor-pointer p-2 rounded text-white">delete</div>
                                    </div>
                                    <div wire:click="changeStatus({{ $foodParty->id }})"
                                        class="cursor-pointer rounded hover:scale-110 transition-all ease-in-out text-white p-2 hover:shadow-xl shadow-green-800/80
                                {{ $foodParty->status == 'active' ? 'bg-green-500' : 'bg-yellow-500' }}
                                ">
                                        {{ $foodParty->status }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-2">
                    {{ $foodParties->links() }}
                </div>
                <livewire:modal-edit-food-party />
            </div>
        </div>
    </div>
