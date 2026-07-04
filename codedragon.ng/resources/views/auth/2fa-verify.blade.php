<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 text-center">
        {{ __('This account has Two-Factor Authentication enabled. Please open your Google Authenticator app and enter the 6-digit code below to securely log in.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('security.2fa.verify.post') }}">
        @csrf

        <!-- 2FA Code -->
        <div>
            <x-input-label for="code" value="{{ __('Authenticator Code') }}" />
            <x-text-input id="code" class="block mt-1 w-full tracking-widest text-center text-2xl" type="text" name="code" required autofocus autocomplete="one-time-code" maxlength="6" placeholder="000000" />
            <x-input-error :messages="$errors->get('code')" class="mt-2 text-center" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="w-full justify-center">
                {{ __('Verify & Login') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
