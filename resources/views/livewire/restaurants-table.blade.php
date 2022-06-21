<div class="w-full">
    <div class="flex justify-between w-full items-center mb-1">
        <div class="font-bold">
            Total type: {{ $restaurants->total() }}
        </div>
        <label for="">
            Food Type
            <select wire:model="foodType" wire:change="fetchData"
                class="p-3 bg-white rounded-full border border-teal-300">
                <option>All</option>
                @foreach ($foodTypes as $foodType)
                    <option value="{{ $foodType->id }}">{{ $foodType->name }}</option>
                @endforeach
            </select>
        </label>
        <input wire:change="fetchData" wire:model.debouns.500ms="search" class="rounded-full p-3 border border-cyan-200"
            type="text" placeholder="search...">
    </div>
    <div class="col-span-12 w-full">
        <div class="w-full overflow-auto lg:overflow-visible">
            <table class="w-full text-gray-400 border-separate space-y-6 text-sm">
                <thead class="bg-teal-800 text-gray-100">
                    <tr>
                        <th class="p-3">ID</th>
                        <th class="p-3">Name</th>
                        <th class="p-3">Type</th>
                        <th class="p-3">Updated at</th>
                        <th class="p-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($restaurants as $restaurant)
                        <tr class="bg-teal-50 text-teal-900 text-center">
                            <td class="p-3">
                                {{ $restaurant->id }}
                            </td>
                            <td class="p-3">
                                <div class="flex justify-center">
                                    <div class="ml-3 self-center font-bold">
                                        {{ $restaurant->name }}
                                    </div>
                                </div>
                            </td>
                            <td class="p-3">
                                {{ $restaurant->foodType['name'] }}
                            </td>
                            <td class="p-3 font-bold">
                                {{ $restaurant->updated_at }}
                            </td>
                            <td class="p-3 font-bold">
                                <div wire:click="$emit('editType', {{ $restaurant->id }}, '{{ $restaurant->name }}')"
                                    class=" hover:text-purple-600 mr-2 cursor-pointer flex justify-center gap-5">
                                    <div wire:click="changeStatus({{ $restaurant->id }})"
                                        class="{{ $restaurant->status == 'active' ? 'text-green-500' : 'text-red-500' }} capitalize">
                                        {{ $restaurant->status }}
                                    </div>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-2">
                {{ $restaurants->links() }}
            </div>
            <div>

            </div>
            {{-- TODO:MODAL --}}


        </div>
    </div>
</div>
