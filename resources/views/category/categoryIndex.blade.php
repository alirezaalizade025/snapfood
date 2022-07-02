@extends('layouts.main')

@section('content')
    <div class="relative w-full">
        <x-navbar></x-navbar>
        <div class="bg-gradient-to-b from-yellow-50 min-h-screen w-full pt-40 p-10 grid grid-cols-10 gap-3">
            <div class="bg-red-500 lg:col-span-2 col-span-10 lg:order-2"></div>
            <div class="bg-black lg:col-span-8 col-span-10"></div>
        </div>
    </div>
@endsection
