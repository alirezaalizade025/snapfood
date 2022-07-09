@extends('layouts.main')

@section('content')
    <div class="relative w-full">
        <x-navbar></x-navbar>
        <div class="bg-gradient-to-b from-[#f1dabf] min-h-screen w-full pt-80 p-10 gap-3">
            <div class="">
                <livewire:customer.cart.cart />
            </div>
        </div>
    </div>
@endsection
