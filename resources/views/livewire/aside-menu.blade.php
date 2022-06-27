<aside
    class="ml-[100%] overflow-auto scrollbar fixed z-10 top-0 pb-3 px-6 w-full flex flex-col justify-between h-screen border-r bg-white transition duration-300 md:w-4/12 lg:ml-0 lg:w-[25%] xl:w-[20%] 2xl:w-[15%]">
    <div>
        <div class="-mx-6 px-6 py-4">
            <a href="{{ route('home') }}" title="home" class="flex gap-2 items-center">
                <img src="https://tailus.io/sources/blocks/food-delivery/preview/images/icon.png" class="w-12"
                    alt="tailus logo" width="144" height="133">
                <span class="text-2xl font-bold text-yellow-900">snap <span class="text-yellow-700">Food</span></span>
            </a>
        </div>

        <div class="mt-3 text-center flex gap-5">
            <div class="w-1/2">
                @isset(auth()->user()->image->path)
                    <img src="{{ auth()->user()->image->path ?? null }}" alt=""
                        class="w-10 h-10 m-auto rounded-full object-cover lg:w-20 lg:h-20">
                @else
                <div class="rounded-full bg-stone-400 text-gray-600 h-20 w-20 flex justify-center items-center">
                    <span class="-rotate-[30deg]">snapfood</span>
                </div>
                @endisset
            </div>
            <div class="">
                <h5 class="hidden mt-4 text-xl font-semibold text-gray-600 lg:block">{{ auth()->user()->name }}</h5>
                <span class="hidden text-gray-400 lg:block">{{ auth()->user()->role }}</span>
            </div>
        </div>

        <ul class="space-y-2 tracking-wide mt-5">
            <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                {{ __('Profile') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('food.index') }}" :active="request()->routeIs('food.index')">
                {{ __('Food') }}
            </x-jet-responsive-nav-link>
            @if (auth()->user()->role == 'admin')
                <x-jet-responsive-nav-link href="{{ route('foodType.index') }}" :active="request()->routeIs('foodType.index')">
                    {{ __('Food Type') }}
                </x-jet-responsive-nav-link>
                <x-jet-responsive-nav-link href="{{ route('restaurant.index') }}" :active="request()->routeIs('restaurant.index')">
                    {{ __('Restarant') }}
                </x-jet-responsive-nav-link>
                <x-jet-responsive-nav-link href="{{ route('discount.index') }}" :active="request()->routeIs('discount.index')">
                    {{ __('Food Party') }}
                </x-jet-responsive-nav-link>
            @endif
            @if (auth()->user()->role == 'restaurant')
                <x-jet-responsive-nav-link href="{{ route('restaurant.show', auth()->id()) }}" :active="request()->routeIs('restaurant.show')">
                    {{ __('My Restaurant') }}
                </x-jet-responsive-nav-link>
            @endif
        </ul>
    </div>

    <form method="POST" action="{{ route('logout') }}"
        class="px-6 -mx-6 pt-4 flex justify-between items-center border-t">
        @csrf
        <button class="px-4 py-3 flex items-center space-x-4 rounded-md text-gray-600 group">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span class="group-hover:text-gray-700">Logout</span>
        </button>
    </form>

</aside>
