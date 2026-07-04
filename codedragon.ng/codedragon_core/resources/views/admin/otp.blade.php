<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('An OTP has been sent to your admin email address. Please enter it below to securely log in.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('admin.otp.verify') }}">
        @csrf

        <!-- OTP Input -->
        <div>
            <x-input-label for="otp" :value="__('6-Digit OTP')" />

            <x-text-input id="otp" class="block mt-1 w-full text-center tracking-widest text-lg" type="text" name="otp" required autofocus autocomplete="off" />

            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Verify OTP & Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
