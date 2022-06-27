 <div>
     <div class="flex justify-between w-full items-center mb-1">
         <div class="font-bold">
             Total Foods: {{ $foods->total() }}
         </div>
     </div>
     <div class="grid lg grid-cols-3 gap-5 p-3 text-center">
         <input wire:model="search" type="text" class="p-3 rounded-full text-center text-black border border-orange-300"
             placeholder="search">
         <select wire:model="foodParty" wire:change="fetchData"
             class="bg-white rounded-full border border-orange-300 px-3">
             <option>All</option>
             @foreach ($foodParties as $foodParty)
                 <option value="{{ $foodParty->id }}">{{ $foodParty->name }}</option>
             @endforeach
         </select>
         <select wire:model="foodType" wire:change="fetchData"
             class="py-1 bg-white rounded-full border border-orange-300 px-3">
             <option>All</option>
             @foreach ($foodTypes as $foodType)
                 <option value="{{ $foodType->id }}">{{ $foodType->name }}</option>
             @endforeach
         </select>
     </div>
     <div class="space-y-5">
         @foreach ($foods as $food)
             <div class="card card-side bg-base-100 shadow-xl">
                 @isset($food->foodParty->discount)
                     <div class="badge badge-secondary badge-outline absolute right-2 top-2">
                         {{ $food->foodParty->discount }}% {{ $food->foodParty->name }}
                     </div>
                 @else
                     @if ($food->discount && $food->discount != 0)
                         <div class="badge badge-secondary badge-outline absolute right-2 top-2">
                             {{ $food->discount }}% off
                         </div>
                     @endif
                 @endisset

                 <figure class="w-1/5 h-54">
                     @isset($food->image->path)
                         <img src="{{ $food->image->path ?? null }}" alt="food">
                     @else
                         <div class="bg-gray-200"></div>
                     @endisset
                 </figure>
                 <div class="card-body w-4/5">
                    <div class="font-bold text-orange-700 text-2xl"><span class="text-blue-500">#</span> {{ $food->foodType->name }}</div>
                     <h2 class="card-title">{{ $food->name }}@if (auth()->user()->role == 'admin')
                             <span class="text-sm">{{ $food->restaurant->title }}</span>
                         @endif
                     </h2>
                     <p class="text-green-600">
                         {{ $food->price * (1 - ($food->foodParty->discount ?? $food->discount) / 100) }} $
                     </p>
                     <div class="flex gap-1">
                         @forelse ($food->rawMaterials as $foodRawMaterial)
                             <div class="px-1 rounded-full bg-stone-300 text-neutral-700">
                                 {{ $foodRawMaterial->name }}
                             </div>
                         @empty
                             <div class="p-1 rounded-full bg-stone-300 text-neutral-700"> No Food
                                 Material saved!</div>
                         @endforelse
                     </div>
                     <div class="flex justify-end gap-2">
                         <div class="text-sm text-gray-400 self-end mr-auto">
                             {{ $food->updated_at->diffForHumans() }}
                         </div>
                         <div class="flex gap-2 p-2 border border-gray-200 rounded-xl">
                             <div @if (auth()->user()->role == 'admin') wire:click="changeStatus({{ $food->id }})" @endif
                                 class="cursor-pointer rounded hover:scale-110 transition-all ease-in-out text-white p-2 hover:shadow-xl shadow-green-800/80
                              {{ $food->confirm == 'accept' ? 'bg-green-500' : ($food->confirm == 'waiting' ? 'bg-yellow-400' : 'bg-red-500') }}">
                                 {{ $food->confirm }}
                             </div>
                             <div class="flex gap-3">
                                 <div @if (auth()->user()->role != 'admin') wire:click="changeStatus({{ $food->id }})" @endif
                                     class="cursor-pointer rounded hover:scale-110 transition-all ease-in-out text-white p-2 hover:shadow-xl shadow-green-800/80 select-none
                                       {{ $food->status == 'active' ? 'bg-blue-500' : 'bg-orange-500' }}">
                                     {{ $food->status }}
                                 </div>
                             </div>
                         </div>
                         @if (auth()->user()->role != 'admin')
                             <div class="flex gap-2 p-2 border border-gray-200 rounded-xl">
                                 <div wire:click="$emit('showEditFoodModal', 'Food', {{ $food->id }})"
                                     class="bg-purple-400 cursor-pointer p-2 rounded text-white">edit</div>
                                 <div wire:click="$emit('showDeleteModal', 'Food', {{ $food->id }})"
                                     class="bg-red-500 cursor-pointer p-2 rounded text-white">delete</div>
                             </div>
                         @endif
                     </div>
                 </div>
             </div>
         @endforeach
     </div>


     <div class="mt-2">
         {{ $foods->links() }}
     </div>
 </div>
