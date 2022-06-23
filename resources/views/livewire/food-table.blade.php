 <div>
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
                 Total type: {{ $foods->total() }}
             </div>
             <input wire:change="fetchData" wire:model.debouns.500ms="search"
                 class="rounded-full p-3 border border-orange-300" type="text" placeholder="search...">
             <label for="">
                 Food Type
                 <select wire:model="foodType" wire:change="fetchData"
                     class="p-3 bg-white rounded-full border border-orange-300">
                     <option>All</option>
                     @foreach ($foodTypes as $foodType)
                         <option value="{{ $foodType->id }}">{{ $foodType->name }}</option>
                     @endforeach
                 </select>
             </label>
             <label for="">
                 Food party
                 <select wire:model="foodParty" wire:change="fetchData"
                     class="p-3 bg-white rounded-full border border-orange-300">
                     <option>All</option>
                     @foreach ($foodParties as $foodParty)
                         <option value="{{ $foodParty->id }}">{{ $foodParty->name }}</option>
                     @endforeach
                 </select>
             </label>
         </div>
         <div class="col-span-12 w-full">
             <div class="w-full overflow-auto lg:overflow-visible">
                 <table class="w-full text-gray-400 border-separate space-y-6 text-sm">
                     <thead class="bg-orange-500 text-gray-100">
                         <tr>
                             <th class="p-3 rounded">ID</th>
                             <th class="p-3 rounded">Name</th>
                             <th class="p-3 rounded">Image</th>
                             <th class="p-3 rounded">Price</th>
                             <th class="p-3 rounded">Discount</th>
                             <th class="p-3 rounded">Final price</th>
                             <th class="p-3 rounded">Food type</th>
                             <th class="p-3 rounded">Updated at</th>
                             <th class="p-3 rounded"></th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($foods as $food)
                             <div>
                                 <tr class="bg-orange-50 text-orange-900 text-center">
                                     <td class="p-3 rounded">
                                         {{ $food->id }}
                                     </td>
                                     <td class="p-3 rounded">
                                         <div class="flex justify-center">
                                             <div class="ml-3 self-center font-bold">
                                                 {{ $food->name }}
                                             </div>
                                         </div>
                                     </td>
                                     {{-- TODO:change group-hover to group-fucos --}}
                                     <td class="p-3 group rounded mx-auto">
                                         @isset($food->image)
                                             <img src="{{ $food->image }}"
                                                 class="m-auto rounded-3xl object-cover w-10 h-10 group-hover:w-36 group-hover:h-36 transition-all duration-500"
                                                 alt="">
                                         @endisset
                                     </td>
                                     <td class="p-3 rounded">
                                         {{ $food->price }}
                                     </td>
                                     <td class="p-3 rounded space-y-2">
                                         <div class="rounded-xl border p-1">{{ $food->discount }}%</div>
                                         <div class="rounded-xl border p-1">
                                             {{ $food->foodParty->name ?? '---' }}
                                         </div>
                                     </td>
                                     <td class="p-3 rounded">
                                         {{ $food->price * (1 - $food->discount / 100) * (1 - ($food->foodParty->discount ?? 0) / 100) }}
                                     </td>
                                     <td class="p-3 rounded">
                                         {{ $food->foodType->name ?? '---' }}
                                     </td>
                                     <td class="p-3 text-sm rounded">
                                         {{ $food->updated_at }}
                                     </td>
                                     <td class="p-3 font-bold rounded flex flex-col gap-2 justify-center items-center">
                                         <div class="flex gap-3">
                                             <div wire:click="$emit('showEditFoodModal', 'Food', {{ $food->id }})"
                                                 class="bg-purple-400 cursor-pointer p-2 rounded text-white">edit</div>
                                             <div wire:click="$emit('showDeleteModal', 'Food', {{ $food->id }})"
                                                 class="bg-red-500 cursor-pointer p-2 rounded text-white">delete</div>
                                         </div>
                                         <div class="flex gap-3">
                                             <div wire:click="changeStatus({{ $food->id }})"
                                                 class="cursor-pointer rounded hover:scale-110 transition-all ease-in-out text-white p-2 hover:shadow-xl shadow-green-800/80
                                                {{ $food->status == 'active' ? 'bg-green-500' : 'bg-yellow-500' }}">
                                                 {{ $food->status }}
                                             </div>
                                             @empty(!$food->rawMaterials->all())
                                                 <div onclick="$('#materials-{{ $food->id }}').slideToggle()"
                                                     class="bg-blue-500 cursor-pointer p-2 rounded text-white text-sm">
                                                     Materials
                                                 </div>
                                             @endempty
                                         </div>
                                     </td>
                                 </tr>
                                 @empty(!$food->rawMaterials->all())
                                     <tr class="bg-orange-50 text-orange-900 text-center">
                                         <td colspan="9" class="p-3 rounded" id="materials-{{ $food->id }}"
                                             style="display:none">
                                             <div class="flex gap-3">
                                                 @foreach ($food->rawMaterials as $foodRawMaterial)
                                                     <div class="p-1 rounded-full bg-stone-300 text-neutral-700">
                                                         {{ $foodRawMaterial->name }}
                                                     </div>
                                                 @endforeach
                                             </div>
                                         </td>
                                     </tr>
                                 @endempty
                             </div>
                         @endforeach
                     </tbody>
                 </table>
                 <div class="mt-2">
                     {{ $foods->links() }}
                 </div>
             </div>
         </div>
     </div>
