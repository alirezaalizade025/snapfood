@extends('layouts.main')

@section('content')
    <div class="relative w-full">
        <x-navbar></x-navbar>
        <div class="bg-gradient-to-b from-yellow-50 min-h-screen w-full pt-40 p-10 grid grid-cols-10 gap-3">
            <div class="lg:col-span-2 col-span-10">
                <livewire:customer.category.show-restaurant-toolbar :category="$category"/>
            </div>
            <div class="lg:col-span-8 col-span-10 sticky">
                <livewire:customer.category.show-restaurants :category="$category" />
            </div>
        </div>
    </div>
@endsection
