<x-guest-layout>
    <div class="flex flex-col sm:justify-center items-center  sm:pt-0 bg-gray-100 h-screen">
        <div class="w-full mt-6 px-6 py-4  overflow-hidden sm:rounded-lg">
            <form method="POST" action="{{ route('register') }}" class=" p-5">
                <x-jet-validation-errors class="mb-4" />
                @csrf
                <div class="relative py-1 sm:max-w-xl sm:mx-auto">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-rose-300 to-rose-600 shadow-lg transform skew-y-6 sm:skew-y-0 sm:rotate-6 sm:rounded-3xl">
                    </div>
                    <div class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20">
                        <div class="max-w-md mx-auto">
                            <div>
                                <h1 class="text-2xl font-semibold">Sign up</h1>
                            </div>
                            <div class="divide-y divide-gray-200">
                                <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                                    <div class="flex gap-5">
                                        <div>
                                            <x-jet-label for="name" value="{{ __('Name') }}" />
                                            <x-jet-input id="name" class="block mt-1 w-full" type="text"
                                                name="name" :value="old('name')" required autofocus
                                                autocomplete="name" />
                                        </div>
                                        <div>
                                            <x-jet-label for="email" value="{{ __('Email') }}" />
                                            <x-jet-input id="email" class="block mt-1 w-full" type="email"
                                                name="email" :value="old('email')" required autofocus />
                                        </div>
                                    </div>
                                    <div class="flex gap-5">
                                        <div class="mt-4">
                                            <x-jet-label for="phone" value="{{ __('Phone') }}" />
                                            <x-jet-input id="phone" class="block mt-1 w-full" type="text"
                                                name="phone" required autocomplete="phone" />
                                        </div>
                                        <div class="mt-4">
                                            <x-jet-label for="bank_account_number"
                                                value="{{ __('Account Number(bank)') }}" />
                                            <x-jet-input id="bank_account_number" class="block mt-1 w-full"
                                                type="text" name="bank_account_number" required
                                                autocomplete="bank_account_number" />
                                        </div>
                                    </div>
                                    <div class="flex gap-5">
                                        <div class="mt-4">
                                            <x-jet-label for="password" value="{{ __('Password') }}" />
                                            <x-jet-input id="password" class="block mt-1 w-full" type="password"
                                                name="password" required autocomplete="current-password" />
                                        </div>
                                        <div class="mt-4">
                                            <x-jet-label for="password_confirmation"
                                                value="{{ __('Confirm Password') }}" />
                                            <x-jet-input id="password_confirmation" class="block mt-1 w-full"
                                                type="password" name="password_confirmation" required
                                                autocomplete="new-password" />
                                        </div>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <div class="block mt-4">
                                            <label for="remember_me" class="flex items-center">
                                                <x-jet-checkbox id="remember_me" name="remember" />
                                                <span
                                                    class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                            </label>
                                        </div>
                                        <div class="relative">
                                            <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                                href="{{ route('login') }}">
                                                {{ __('Already registered?') }}
                                            </a>
                                        </div>
                                    </div>
                                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                        <div class="mt-4">
                                            <x-jet-label for="terms">
                                                <div class="flex items-center">
                                                    <x-jet-checkbox name="terms" id="terms" />

                                                    <div class="ml-2">
                                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
    'terms_of_service' => '<a target="_blank" href="' . route('terms.show') . '" class="underline text-sm text-gray-600 hover:text-gray-900">' . __('Terms of Service') . '</a>',
    'privacy_policy' => '<a target="_blank" href="' . route('policy.show') . '" class="underline text-sm text-gray-600 hover:text-gray-900">' . __('Privacy Policy') . '</a>',
]) !!}
                                                    </div>
                                                </div>
                                            </x-jet-label>
                                        </div>
                                    @endif
                                    <x-jet-button class="ml-4 w-full text-center mx-2 bg-rose-600">
                                        {{ __('sign up') }}
                                    </x-jet-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
