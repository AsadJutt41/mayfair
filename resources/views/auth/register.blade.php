<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img src="{{asset('assets/images/brand/logo.png')}}" class="header-brand-img desktop-lgo" alt="MayFair Logo" style="width: 150px; height: 100px;">
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label for="firstname" value="{{ __('First Name') }}" />
                <x-jet-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
            </div>

            <div>
                <x-jet-label for="lastname" value="{{ __('Last Name') }}" />
                <x-jet-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')"  autofocus autocomplete="lastname" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" />
            </div>

            <div class="mt-4">
                <x-jet-label for="phone_number" value="{{ __('Phone Number') }}" />
                <x-jet-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')"  />
            </div>

            <div class="mt-4">
                <x-jet-label for="designation" value="{{ __('Designation') }}" />
                <x-jet-input id="designation" class="block mt-1 w-full" type="text" name="designation" :value="old('designation')"  />
            </div>

            <div class="mt-4">
                <x-jet-label for="role" value="{{ __('Role') }}" />
                <x-jet-input id="role" class="block mt-1 w-full" type="text" name="role" :value="old('role')"  />
            </div>

            <div class="mt-4">
                <x-jet-label for="line_manager" value="{{ __('Line Manager') }}" />
                <x-jet-input id="line_manager" class="block mt-1 w-full" type="text" name="line_manager" :value="old('line_manager')"  />
            </div>

            <div class="mt-4">
                <x-jet-label for="over_limit_approver" value="{{ __('over_limit_approver') }}" />
                <x-jet-input id="over_limit_approver" class="block mt-1 w-full" type="text" name="over_limit_approver" :value="old('over_limit_approver')"  />
            </div>

            <div class="mt-4">
                <x-jet-label for="sap_id" value="{{ __('Sap ID') }}" />
                <x-jet-input id="sap_id" class="block mt-1 w-full" type="text" name="sap_id" :value="old('sap_id')"  />
            </div>

            <div class="mt-4">
                <x-jet-label for="joining_date" value="{{ __('joining_date') }}" />
                <x-jet-input id="joining_date" class="block mt-1 w-full" type="text" name="joining_date" :value="old('joining_date')"  />
            </div>

            <div class="mt-4">
                <x-jet-label for="base_town" value="{{ __('base_town') }}" />
                <x-jet-input id="base_town" class="block mt-1 w-full" type="text" name="base_town" :value="old('base_town')"  />
            </div>

            <div class="mt-4">
                <x-jet-label for="zone" value="{{ __('zone') }}" />
                <x-jet-input id="zone" class="block mt-1 w-full" type="text" name="zone" :value="old('zone')"  />
            </div>

            <div class="mt-4">
                <x-jet-label for="address" value="{{ __('address') }}" />
                <x-jet-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')"  />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms"/>

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
