 <div>
     <div class="flex justify-between w-full items-center mb-1">
         <div class="font-bold">
             Total Foods: {{ $foods->total() }}
         </div>
     </div>
     <div class="col-span-12 w-full">
         <div class="w-full overflow-auto lg:overflow-visible">
             <table class="w-full text-gray-400 border-separate space-y-6 text-sm">
                 <thead class="bg-orange-500 text-gray-100">
                     <tr>
                         <th class="p-3 rounded">ID</th>
                         <th class="p-3 rounded"><div>Name <br> & <br> restaurant</div>
                            <input wire:model="search" type="text" class="p-1 rounded-full text-center text-black" placeholder="search">
                        </th>
                         <th class="p-3 rounded">Image</th>
                         <th class="p-3 rounded">Price <br> & <br> final price</th>
                         <th class="p-3 rounded">
                             <div class=" flex flex-col justify-between">
                                 <div>Discount & <br> Food Party</div>
                                 <div class="text-black">
                                     <select wire:model="foodParty" wire:change="fetchData"
                                         class="py-1 bg-white rounded-full border border-orange-300">
                                         <option>All</option>
                                         @foreach ($foodParties as $foodParty)
                                             <option value="{{ $foodParty->id }}">{{ $foodParty->name }}</option>
                                         @endforeach
                                     </select>
                                 </div>
                             </div>
                         </th>
                         <th class="p-3 rounded">
                             <div class="flex flex-col justify-between gap-5">
                                 <div>Food type</div>
                                 <div class="text-black">
                                     <select wire:model="foodType" wire:change="fetchData"
                                         class="py-1 bg-white rounded-full border border-orange-300">
                                         <option>All</option>
                                         @foreach ($foodTypes as $foodType)
                                             <option value="{{ $foodType->id }}">{{ $foodType->name }}</option>
                                         @endforeach
                                     </select>
                                 </div>
                             </div>
                         </th>
                         <th class="p-3 rounded">Updated at</th>
                         <th class="p-3 rounded">confirm <br> & <br> status</th>
                     </tr>
                 </thead>
                 <tbody>
                     @foreach ($foods as $food)
                         <div>
                             <tr onclick="$('#materials-{{ $food->id }}').slideToggle()"
                                 class="bg-orange-50 text-orange-900 text-center">
                                 <td class="p-3 rounded">
                                     {{ $food->id }}
                                 </td>
                                 <td class="p-3 rounded">
                                     <div class="flex justify-center">
                                         <div class="ml-3 self-center font-bold">
                                             {{ $food->name }} <br>({{ $food->restaurant->name }})
                                         </div>
                                     </div>
                                 </td>
                                 <td class="p-3 group rounded mx-auto">
                                     @isset($food->image)
                                         <img src="{{ $food->image }}"
                                             class="m-auto rounded-3xl object-cover w-10 h-10 group-hover:w-28 group-hover:h-28 transition-all duration-500"
                                             alt="">
                                     @endisset
                                 </td>
                                 <td class="p-3 rounded">
                                     {{ $food->price }}
                                     <br>
                                     {{ $food->price * (1 - $food->discount / 100) * (1 - ($food->foodParty->discount ?? 0) / 100) }}
                                 </td>
                                 <td class="p-3 rounded space-y-2">
                                     <div class="rounded-xl border p-1">{{ $food->discount }}%</div>
                                     <div class="rounded-xl border p-1">
                                         {{ $food->foodParty->name ?? '---' }}
                                     </div>
                                 </td>
                                 <td class="p-3 rounded">
                                     {{ $food->foodType->name ?? '---' }}
                                 </td>
                                 <td class="p-3 text-sm rounded">
                                     {{ $food->updated_at->diffForHumans() }}
                                 </td>
                                 <td class="p-3 font-bold rounded flex flex-col gap-2 justify-center items-center">
                                     <div wire:click="changeStatus({{ $food->id }})"
                                         class="cursor-pointer rounded hover:scale-110 transition-all ease-in-out text-white p-2 hover:shadow-xl shadow-green-800/80
                                           {{ $food->confirm == 'accept' ? 'bg-green-500' : ($food->confirm == 'waiting' ? 'bg-yellow-400' : 'bg-red-500') }}">
                                         {{ $food->confirm }}
                                     </div>
                                     @if (auth()->user()->role != 'admin')
                                         <div class="flex gap-3">
                                             <div wire:click="$emit('showEditFoodModal', 'Food', {{ $food->id }})"
                                                 class="bg-purple-400 cursor-pointer p-2 rounded text-white">edit</div>
                                             <div wire:click="$emit('showDeleteModal', 'Food', {{ $food->id }})"
                                                 class="bg-red-500 cursor-pointer p-2 rounded text-white">delete</div>
                                         </div>
                                     @endif
                                     <div class="flex gap-3">
                                         <div wire:click="changeStatus({{ $food->id }})"
                                             class="cursor-pointer rounded hover:scale-110 transition-all ease-in-out text-white p-2 hover:shadow-xl shadow-green-800/80
                                                {{ $food->status == 'active' ? 'bg-green-500' : 'bg-orange-500' }}">
                                             {{ $food->status }}
                                         </div>
                                     </div>
                                 </td>
                             </tr>
                             <tr class="bg-orange-50 text-orange-900 text-center">
                                 <td colspan="9" class="p-3 rounded" id="materials-{{ $food->id }}"
                                     style="display:none">
                                     <div class="flex gap-3">
                                         @forelse ($food->rawMaterials as $foodRawMaterial)
                                             <div class="p-1 rounded-full bg-stone-300 text-neutral-700">
                                                 {{ $foodRawMaterial->name }}
                                             </div>
                                         @empty
                                             <div class="p-1 rounded-full bg-stone-300 text-neutral-700"> No Food
                                                 Material saved!</div>
                                         @endforelse
                                     </div>
                                 </td>
                             </tr>

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
