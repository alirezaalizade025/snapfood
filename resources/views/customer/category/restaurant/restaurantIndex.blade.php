@extends('layouts.main')

@section('content')
    <div class="relative w-full">
        <x-navbar></x-navbar>
        <div class="bg-gradient-to-b from-yellow-50 min-h-screen w-full pt-40 p-10 grid grid-cols-10 gap-10">
            <div class="col-span-10 shadow-xl shadow-cyan-300/30 rounded-3xl overflow-auto">
                <div class="w-full h-full bg-gradient-to-r from-[#c0ecf3] to-[#ffe5c6] flex">
                    <div class="font-bold text-4xl p-10">
                        <div class="bg-clip-text text-transparent bg-gradient-to-r from-[#f0735a] to-[#dd2476]">
                            {{ $restaurant->title }}
                        </div>
                        <div class="text-[1.5rem] text-sky-500">
                            #{{ $restaurant->category->pluck('name')->implode(' #') }}
                        </div>
                        <div
                            class="mt-20 bg-clip-text text-transparent text-lg bg-gradient-to-r from-[#f0735a] to-[#dd2476]">
                            {{ $restaurant->addressInfo->address }}
                        </div>
                        <div class="mt-5 bg-clip-text text-transparent text-lg bg-gradient-to-r from-[#f0735a] to-[#dd2476]">
                            {{ $restaurant->phone }}
                        </div>
                    </div>
                    @isset($restaurant->image)
                        <img src="{{ $restaurant->image->path }}" class="w-80 h-full ml-auto object-cover" alt="">
                    @endisset
                </div>
            </div>
            <div class="lg:col-span-7 col-span-10 rounded-3xl overflow-auto border drop-shadow-xl">
                <livewire:customer.category.restaurant.show-foods :restaurant="$restaurant" />
            </div>
            <div class="lg:col-span-3 col-span-10 sticky drop-shadow-xl border max-h-screen overflow-auto rounded-3xl">
                @livewire('customer.cart.side-cart', ['restaurant' => $restaurant], key($restaurant->id))
            </div>
            <livewire:customer.comment.food-modal />
        </div>
    </div>
@endsection
