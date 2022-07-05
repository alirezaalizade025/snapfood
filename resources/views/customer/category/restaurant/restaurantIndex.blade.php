@extends('layouts.main')

@section('content')
    <div class="relative w-full">
        <x-navbar></x-navbar>
        <div class="bg-gradient-to-b from-yellow-50 min-h-screen w-full pt-40 p-10 grid grid-cols-10 gap-10">
            <div class="col-span-10 shadow-xl shadow-cyan-300/30 p-5 rounded-3xl">
                scroll in page titles
                {{-- <livewire:customer.category.show-restaurant-toolbar :category="$category"/> --}}
            </div>
            <div class="lg:col-span-7 col-span-10 rounded-3xl overflow-auto border drop-shadow-xl">
                <livewire:customer.category.restaurant.show-foods :restaurant="$restaurant" />
            </div>
            <div class="lg:col-span-3 col-span-10 sticky drop-shadow-xl border max-h-screen overflow-auto rounded-3xl">
                @livewire('customer.cart.side-cart', ['restaurant' => $restaurant], key($restaurant->id))
            </div>
        </div>
    </div>
@endsection
