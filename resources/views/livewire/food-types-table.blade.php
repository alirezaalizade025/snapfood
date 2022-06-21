<div class="w-full">
    <div class="flex justify-between w-full items-center mb-1">
        <div class="font-bold">
            Total type: {{ $foodTypes->total() }}
        </div>
        <input wire:change="fetchData" wire:model.debouns.500ms="search" class="rounded-full p-2 border border-cyan-200"
            type="text" placeholder="search...">
    </div>
    <div class="col-span-12 w-full">
        <div class="w-full overflow-auto lg:overflow-visible">
            <table class="w-full text-gray-400 border-separate space-y-6 text-sm">
                <thead class="bg-sky-800 text-gray-100">
                    <tr>
                        <th class="p-3">Name</th>
                        <th class="p-3">ID</th>
                        <th class="p-3">Updated at</th>
                        <th class="p-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($foodTypes as $foodType)
                        <tr class="bg-sky-50 text-sky-900 text-center">
                            <td class="p-3">
                                <div class="flex justify-center">
                                    <div class="ml-3 self-center font-bold">
                                        {{ $foodType->name }}
                                    </div>
                                </div>
                            </td>
                            <td class="p-3">
                                {{ $foodType->id }}
                            </td>
                            <td class="p-3 font-bold">
                                {{ $foodType->updated_at }}
                            </td>
                            <td class="p-3 font-bold flex justify-evenly">
                                <div wire:click="$emit('editType', {{ $foodType->id }}, '{{ $foodType->name }}')"
                                    class="text-purple-400 hover:text-purple-600 mr-2 cursor-pointer">
                                    Edit
                                </div>
                                <div wire:click="$emit('showDeleteModal', 'FoodType', {{ $foodType->id }})"
                                    class="text-red-400 hover:text-red-600  mx-2 cursor-pointer">
                                    Delete
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-2">
                {{ $foodTypes->links() }}
            </div>
            <div>

            </div>
            {{-- TODO:MODAL --}}


        </div>
    </div>
</div>
