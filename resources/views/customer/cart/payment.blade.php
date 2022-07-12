@extends('layouts.main')

@section('content')
    <div class="h-screen w-full bg-gradient-to-br from-sky-300 to-indigo-400 grid">
        <form method="post" action="{{ route('payment.store') }}" class="m-auto flex gap-10">
            @csrf
            <input type="hidden" name="cart_id" value="{{ $id }}">
            <button value="error" name="status" class="bg-red-500 rounded-xl text-white px-10 py-5">خطا در پرداخت</button>
            <button value="success" name="status" class="bg-green-500 rounded-xl text-white px-10 py-5">عملیات موفق</button>
        </form>
    </div>
@endsection
