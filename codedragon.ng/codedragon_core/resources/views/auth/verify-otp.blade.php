<x-guest-layout>
    <style>
        .traditional-input {
            background: rgba(15, 10, 30, 0.8) !important;
            border: 2px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 4px !important;
            padding: 1.5rem !important;
            font-size: 2.2rem !important;
            font-weight: 900 !important;
            letter-spacing: 0.4em !important;
            text-align: center !important;
            color: #fff !important;
            width: 100%;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .traditional-input:focus {
            border-color: #B91C1C !important;
            box-shadow: 0 0 20px rgba(139, 92, 246, 0.4) !important;
            outline: none;
        }
        .label-text { font-weight: 800; color: #fff; margin-bottom: 1.25rem; display: block; font-size: 1.2rem; text-align: center; text-transform: uppercase; letter-spacing: 1px; }
    </style>

    <h2 class="text-3xl font-black text-white mb-6 text-center">Verify Identity</h2>

    <div class="mb-8 text-center text-gray-400 font-bold px-4">
        {{ __('A verification code has been sent to your email address. Please enter it below to proceed.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf

        <!-- OTP Input -->
        <div class="mb-10">
            <label class="label-text" for="otp">Enter 6-Digit Code</label>
            <input id="otp" class="traditional-input" type="text" name="otp" required autofocus autocomplete="off" placeholder="000000" maxlength="6" />
            <x-input-error :messages="$errors->get('otp')" class="mt-2 text-center" />
        </div>

        <div class="mt-8">
            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-black py-5 rounded-md transition transform hover:-translate-y-1 shadow-lg shadow-purple-500/20 text-xl tracking-widest">
                {{ __('VERIFY MY ACCOUNT') }}
            </button>
        </div>
    </form>

    <div class="mt-10 text-center">
        <form id="resendForm" method="POST" action="{{ route('otp.resend') }}">
            @csrf
            <button type="submit" id="resendBtn" disabled class="text-sm font-bold text-gray-500 cursor-not-allowed transition-all duration-300">
                Resend Code in <span id="timer">60</span>s
            </button>
        </form>
    </div>

    <script>
        let timeLeft = 60;
        const timerSpan = document.getElementById('timer');
        const resendBtn = document.getElementById('resendBtn');

        const countdown = setInterval(() => {
            timeLeft--;
            timerSpan.textContent = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(countdown);
                resendBtn.disabled = false;
                resendBtn.classList.remove('text-gray-500', 'cursor-not-allowed');
                resendBtn.classList.add('text-purple-400', 'hover:text-white', 'cursor-pointer');
                resendBtn.textContent = 'Resend Verification Code';
            }
        }, 1000);
    </script>
</x-guest-layout>
