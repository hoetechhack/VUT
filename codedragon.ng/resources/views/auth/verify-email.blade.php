<x-guest-layout>
    <div style="text-align: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.75rem; font-weight: 900; color: #fff; margin-bottom: 8px;">Verify Email</h2>
        <p style="color: var(--muted); font-size: 0.9rem; font-weight: 600;">Check your inbox to get started.</p>
    </div>

    <div style="margin-bottom: 1.5rem; text-align: center; font-size: 0.85rem; color: var(--muted); line-height: 1.6; font-weight: 600;">
        {{ __('Thanks for signing up! Please verify your email by clicking the link we sent you. If you didn\'t get it, we can send it again.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div style="background:rgba(34,197,94,0.1); border:1px solid #22c55e; color:#22c55e; padding:1rem; border-radius:12px; margin-bottom:1.5rem; font-size:.85rem; font-weight:700; text-align:center;">
            ✅ {{ __('A new verification link has been sent!') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="bsub">
            {{ __('Resend Verification Email') }}
        </button>
    </form>

    <div style="margin-top: 2rem; pt: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05); text-align: center;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background:none; border:none; color:var(--muted); font-size:0.85rem; font-weight:800; cursor:pointer; text-decoration:underline;">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
