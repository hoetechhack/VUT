<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Security & 2FA') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 bg-green-100 p-4 rounded-md">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Two-Factor Authentication (Google Authenticator)</h3>
                    
                    @if($user->two_factor_enabled)
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                            <p class="text-green-800 font-semibold">2FA is Currently Enabled.</p>
                            <p class="text-sm text-green-700 mt-1">Your account is highly secure. You will be required to enter a 6-digit code from Google Authenticator every time you log in.</p>
                        </div>
                        
                        <form action="{{ route('security.2fa.disable') }}" method="POST" class="mt-6">
                            @csrf
                            <div class="max-w-md">
                                <label class="block text-sm font-medium text-gray-700">Enter your password to disable 2FA:</label>
                                <input type="password" name="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <x-danger-button class="mt-4">
                                    {{ __('Disable 2FA') }}
                                </x-danger-button>
                            </div>
                        </form>
                    @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6">
                            <p class="text-yellow-800 font-semibold">2FA is Not Enabled.</p>
                            <p class="text-sm text-yellow-700 mt-1">Enhance your account security by enabling Two-Factor Authentication via the Google Authenticator app.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="flex flex-col items-center justify-center p-4 border rounded-lg bg-gray-50">
                                <h4 class="font-bold mb-4 text-center">Step 1: Scan this QR Code</h4>
                                <img src="{{ $qrCodeUrl }}" alt="QR Code" class="w-48 h-48 border bg-white p-2">
                                <p class="text-xs text-gray-500 mt-4 text-center">Or enter this secret manually:<br><strong class="text-gray-800 tracking-widest">{{ $user->two_factor_secret }}</strong></p>
                            </div>

                            <div class="flex flex-col justify-center">
                                <h4 class="font-bold mb-4">Step 2: Enter the 6-digit code</h4>
                                <p class="text-sm text-gray-600 mb-4">After scanning the QR code, your app will generate a 6-digit code. Enter it below to verify and enable 2FA.</p>
                                
                                <form action="{{ route('security.2fa.enable') }}" method="POST">
                                    @csrf
                                    <div>
                                        <input type="text" name="code" placeholder="000000" maxlength="6" required class="block w-full text-center tracking-widest text-xl rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error('code')
                                            <p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <x-primary-button class="mt-4 w-full justify-center">
                                        {{ __('Enable 2FA Now') }}
                                    </x-primary-button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
