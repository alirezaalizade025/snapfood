<nav class="fixed z-10 w-full bg-white md:absolute md:bg-transparent">
    <div class="container m-auto px-2 md:px-12 lg:px-7">
        <div class="flex flex-wrap items-center justify-between py-3 gap-6 md:py-4 md:gap-0">
            <div class="w-full px-6 flex justify-between lg:w-max md:px-0">
                <a href="https://tailus.io/blocks/hero-section" aria-label="logo" class="flex space-x-2 items-center">
                    <img src="https://tailus.io/sources/blocks/food-delivery/preview/images/icon.png" class="w-12"
                        alt="tailus logo" width="144" height="133">
                    <span class="text-2xl font-bold text-yellow-900">snap <span
                            class="text-yellow-700">Food</span></span>
                </a>

                <button onclick="$('#navbar').slideToggle()" aria-label="humburger" id="hamburger"
                    class="relative w-10 h-10 -mr-2 lg:hidden">
                    <div aria-hidden="true" id="line"
                        class="inset-0 w-6 h-0.5 m-auto rounded bg-yellow-900 transtion duration-300"></div>
                    <div aria-hidden="true" id="line2"
                        class="inset-0 w-6 h-0.5 mt-2 m-auto rounded bg-yellow-900 transtion duration-300"></div>
                </button>
            </div>

            <div id="navbar"
                class="hidden w-full lg:flex flex-wrap justify-between items-center space-y-6 p-6 rounded-xl bg-white md:space-y-0 md:p-0 md:flex-nowrap md:bg-transparent lg:w-7/12">
                <div class="text-gray-600 lg:pr-4">
                    <ul class="space-y-6 tracking-wide font-medium text-sm md:flex md:space-y-0">
                        <li>
                            @auth
                                <a class="block md:px-4 transition hover:text-yellow-700">
                                    <span class="font-bold">Hi <span
                                            class="rounded-full p-2 bg-emerald-500 text-white">{{ auth()->user()->name }}</span></span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="block md:px-4 transition hover:text-yellow-700">
                                    <span>Cart</span>
                                </a>
                            @endauth
                        </li>
                    </ul>
                </div>

                <div
                    class="w-full md:my-2 lg:space-y-0 md:w-max flex justify-center items-center gap-2 border-t-2 md:border-t-0 py-3">
                    @auth
                        @if (auth()->user()->role == 'customer')
                            <form method="POST" action="{{ route('logout') }}" class="flex justify-between items-center">
                                @csrf
                                <button
                                    class="w-full py-3 px-6 text-center rounded-full transition bg-rose-300 hover:bg-rose-100 active:bg-rose-400 focus:bg-rose-300 sm:w-max">
                                    <span class="block text-rose-900 font-semibold text-sm">
                                        Logout
                                    </span>
                                </button>
                            </form>
                        @else
                            <a href="{{ url('/dashboard') }}" title="Start buying" class="">
                                <div
                                    class="w-full py-3 px-6 text-center rounded-full transition bg-yellow-300 hover:bg-yellow-100 active:bg-yellow-400 focus:bg-yellow-300 sm:w-max">
                                    <span class="block text-yellow-900 font-semibold text-sm">
                                        Dashboard
                                    </span>
                                </div>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}" title="Start buying" class="">
                            <div
                                class="w-full py-3 px-6 text-center rounded-full transition active:bg-yellow-200 focus:bg-yellow-100 sm:w-max border">
                                <span class="block text-yellow-800 font-semibold text-sm">
                                    Sign up
                                </span>
                            </div>
                        </a>
                        <a href="{{ route('login') }}" title="Start buying">
                            <div
                                class="w-full py-3 px-6 text-center rounded-full transition bg-yellow-300 hover:bg-yellow-100 active:bg-yellow-400 focus:bg-yellow-300 sm:w-max">
                                <span class="block text-yellow-900 font-semibold text-sm">
                                    Login
                                </span>
                            </div>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>
