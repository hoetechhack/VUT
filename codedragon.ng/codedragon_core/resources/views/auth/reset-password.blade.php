<x-guest-layout>
    <div style="text-align: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.75rem; font-weight: 900; color: #fff; margin-bottom: 8px;">New Password</h2>
        <p style="color: var(--muted); font-size: 0.9rem; font-weight: 600;">Secure your account with a fresh one.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div style="margin-bottom: 1.25rem;">
            <label class="fl" for="email">Email Address</label>
            <input id="email" class="fctl" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" style="margin-top: 6px; color: #ef4444; font-size: 0.8rem; font-weight: 700;" />
        </div>

        <!-- Password -->
        <div style="margin-bottom: 1.25rem;">
            <label class="fl" for="password">Choose New Password</label>
            <div style="position: relative;">
                <input id="password" class="fctl" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                <button type="button" class="monkey-toggle" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; font-size: 1.2rem; cursor: pointer;">🙈</button>
            </div>
            <x-input-error :messages="$errors->get('password')" style="margin-top: 6px; color: #ef4444; font-size: 0.8rem; font-weight: 700;" />
        </div>

        <!-- Confirm Password -->
        <div style="margin-bottom: 1.5rem;">
            <label class="fl" for="password_confirmation">Confirm New Password</label>
            <div style="position: relative;">
                <input id="password_confirmation" class="fctl" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                <button type="button" class="monkey-toggle" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; font-size: 1.2rem; cursor: pointer;">🙈</button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" style="margin-top: 6px; color: #ef4444; font-size: 0.8rem; font-weight: 700;" />
        </div>

        <button type="submit" class="bsub">
            {{ __('Save New Password') }}
        </button>
    </form>

    <script>
        document.querySelectorAll('.monkey-toggle').forEach(btn => {
            const input = btn.previousElementSibling;
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                btn.textContent = type === 'password' ? '🙈' : '🐵';
            });
        });
    </script>
</x-guest-layout>
