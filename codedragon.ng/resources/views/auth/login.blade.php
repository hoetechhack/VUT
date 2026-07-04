<x-guest-layout>
    <div style="text-align: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.75rem; font-weight: 900; color: #fff; margin-bottom: 8px;">Welcome Back</h2>
        <p style="color: var(--muted); font-size: 0.9rem; font-weight: 600;">Log in to manage your super app</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div style="margin-bottom: 1.5rem;">
            <label class="fl" for="email">Email Address</label>
            <input id="email" class="fctl" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" style="margin-top: 8px; color: #ef4444; font-size: 0.8rem; font-weight: 700;" />
        </div>

        <!-- Password -->
        <div style="margin-bottom: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <label class="fl" for="password">Password</label>
                <!-- Forgot Password temporarily disabled due to server email limitations
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size: 0.75rem; font-weight: 800; color: var(--purple); text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px;">Forgot Password?</a>
                @endif
                -->
            </div>
            <div style="position: relative;">
                <input id="password" class="fctl" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                <button type="button" id="togglePassword" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; font-size: 1.2rem; cursor: pointer;">🙈</button>
            </div>
            <x-input-error :messages="$errors->get('password')" style="margin-top: 8px; color: #ef4444; font-size: 0.8rem; font-weight: 700;" />
        </div>

        <!-- Remember Me -->
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 1.5rem;">
            <input id="remember_me" type="checkbox" name="remember" style="width: 18px; height: 18px; accent-color: var(--purple);">
            <span style="font-size: 0.85rem; font-weight: 700; color: var(--muted);">Keep me logged in</span>
        </div>

        <button type="submit" class="bsub">
            {{ __('Log In') }}
        </button>

        <div style="margin-top: 1.5rem;">
            <a href="/auth/google/redirect" class="google-btn">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" width="20" alt="Google">
                {{ __('Continue with Google') }}
            </a>
        </div>
        
        <div style="margin-top: 2rem; pt: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05); text-align: center;">
            <p style="font-size: 0.85rem; font-weight: 600; color: var(--muted);">
                Don't have an account? 
                <a href="{{ route('register') }}" style="color: var(--purple); font-weight: 800; text-decoration: none;">Create one</a>
            </p>
        </div>
    </form>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const pass = document.getElementById('password');
            const type = pass.getAttribute('type') === 'password' ? 'text' : 'password';
            pass.setAttribute('type', type);
            this.textContent = type === 'password' ? '🙈' : '🐵';
        });
    </script>
</x-guest-layout>
