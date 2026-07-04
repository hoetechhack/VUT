<x-guest-layout>
    <div style="text-align: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.75rem; font-weight: 900; color: #fff; margin-bottom: 8px;">Reset Access</h2>
        <p style="color: var(--muted); font-size: 0.9rem; font-weight: 600;">Lost your password? We'll help you out.</p>
    </div>

    <div style="margin-bottom: 1.5rem; text-align: center; font-size: 0.85rem; color: var(--muted); line-height: 1.6; font-weight: 600;">
        {{ __('No problem. Just enter your email and we\'ll send you a secure link to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div style="margin-bottom: 1.5rem;">
            <label class="fl" for="email">Email Address</label>
            <input id="email" class="fctl" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" style="margin-top: 8px; color: #ef4444; font-size: 0.8rem; font-weight: 700;" />
        </div>

        <button type="submit" class="bsub">
            {{ __('Send Reset Link') }}
        </button>

        <div style="margin-top: 2rem; pt: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05); text-align: center;">
            <a href="{{ route('login') }}" style="font-size: 0.85rem; font-weight: 800; color: var(--purple); text-decoration: none;">
                &larr; Back to Login
            </a>
        </div>
    </form>
</x-guest-layout>
