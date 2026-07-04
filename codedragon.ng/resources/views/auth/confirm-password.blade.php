<x-guest-layout>
    <div style="text-align: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.75rem; font-weight: 900; color: #fff; margin-bottom: 8px;">Security Check</h2>
        <p style="color: var(--muted); font-size: 0.9rem; font-weight: 600;">Confirm your identity to continue.</p>
    </div>

    <div style="margin-bottom: 1.5rem; text-align: center; font-size: 0.85rem; color: var(--muted); line-height: 1.6; font-weight: 600;">
        {{ __('This is a secure area. Please confirm your password before we let you through.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div style="margin-bottom: 1.5rem;">
            <label class="fl" for="password">Confirm Password</label>
            <div style="position: relative;">
                <input id="password" class="fctl" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                <button type="button" id="togglePassword" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; font-size: 1.2rem; cursor: pointer;">🙈</button>
            </div>
            <x-input-error :messages="$errors->get('password')" style="margin-top: 8px; color: #ef4444; font-size: 0.8rem; font-weight: 700;" />
        </div>

        <button type="submit" class="bsub">
            {{ __('Confirm Password') }}
        </button>
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
