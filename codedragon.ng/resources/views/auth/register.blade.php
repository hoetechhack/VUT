<x-guest-layout>
    <div style="text-align: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.75rem; font-weight: 900; color: #fff; margin-bottom: 8px;">Create Account</h2>
        <p style="color: var(--muted); font-size: 0.9rem; font-weight: 600;">Join the CodeDragon super app community</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div style="margin-bottom: 1.25rem;">
            <label class="fl" for="name">Full Name</label>
            <input id="name" class="fctl" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" style="margin-top: 6px; color: #ef4444; font-size: 0.8rem; font-weight: 700;" />
        </div>

        <!-- Email Address -->
        <div style="margin-bottom: 1.25rem;">
            <label class="fl" for="email">Email Address</label>
            <input id="email" class="fctl" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" style="margin-top: 6px; color: #ef4444; font-size: 0.8rem; font-weight: 700;" />
        </div>

        <!-- Password -->
        <div style="margin-bottom: 1.25rem;">
            <label class="fl" for="password">Create Password</label>
            <div style="position: relative;">
                <input id="password" class="fctl" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                <button type="button" class="monkey-toggle" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; font-size: 1.2rem; cursor: pointer;">🙈</button>
            </div>
            <x-input-error :messages="$errors->get('password')" style="margin-top: 6px; color: #ef4444; font-size: 0.8rem; font-weight: 700;" />
        </div>

        <!-- Confirm Password -->
        <div style="margin-bottom: 1.5rem;">
            <label class="fl" for="password_confirmation">Confirm Password</label>
            <div style="position: relative;">
                <input id="password_confirmation" class="fctl" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                <button type="button" class="monkey-toggle" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; font-size: 1.2rem; cursor: pointer;">🙈</button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" style="margin-top: 6px; color: #ef4444; font-size: 0.8rem; font-weight: 700;" />
        </div>

        <!-- Terms Acceptance -->
        <div style="margin-bottom: 1.5rem;">
            <label style="display: flex; align-items: flex-start; gap: 8px; font-size: 0.85rem; font-weight: 600; color: var(--muted); cursor: pointer;">
                <input type="checkbox" name="terms" value="1" {{ old('terms') ? 'checked' : '' }} required style="margin-top: 3px;" />
                <span>
                    I agree to the
                    <a href="/terms" target="_blank" style="color: var(--purple); font-weight: 800; text-decoration: none;">Terms & Conditions</a>
                    and
                    <a href="/privacy-policy" target="_blank" style="color: var(--purple); font-weight: 800; text-decoration: none;">Privacy Policy</a>
                </span>
            </label>
            <x-input-error :messages="$errors->get('terms')" style="margin-top: 6px; color: #ef4444; font-size: 0.8rem; font-weight: 700;" />
        </div>

        <button type="submit" class="bsub">
            {{ __('Get Started') }}
        </button>

        <div style="margin-top: 2rem; pt: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05); text-align: center;">
            <p style="font-size: 0.85rem; font-weight: 600; color: var(--muted);">
                Already have an account? 
                <a href="{{ route('login') }}" style="color: var(--purple); font-weight: 800; text-decoration: none;">Log in</a>
            </p>
        </div>
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
