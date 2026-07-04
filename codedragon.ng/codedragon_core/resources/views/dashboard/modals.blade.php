<div class="mo" id="mo-fund" onclick="cm(event)">
    <div class="md">
        <div class="mdi">💳</div>
        <h3>Fund Your Wallet</h3>
        @if(auth()->user()->bvn_verified_at || auth()->user()->is_verified) 
            @if(auth()->user()->wallet && auth()->user()->wallet->virtual_account_number)
                <p>Transfer to your unique account below. It credits instantly.</p>
                <div style="background:rgba(255,255,255,0.05); padding:1rem; border-radius:10px; text-align:left; border:1px solid rgba(255,255,255,0.1)">
                    <div style="font-size:10px; color:rgba(255,255,255,0.5)">BANK NAME</div>
                    <div style="font-weight:700; margin-bottom:10px">{{ auth()->user()->wallet->virtual_bank_name }}</div>
                    <div style="font-size:10px; color:rgba(255,255,255,0.5)">ACCOUNT NUMBER</div>
                    <div style="font-weight:900; font-size:1.2rem; color:var(--purple)">{{ auth()->user()->wallet->virtual_account_number }}</div>
                    <div style="font-size:10px; color:rgba(255,255,255,0.5); margin-top:10px">ACCOUNT NAME</div>
                    <div style="font-weight:700">{{ auth()->user()->wallet->virtual_account_name }}</div>
                </div>
            @else
                <p>Your virtual account is being generated. Please refresh in a moment.</p>
            @endif
        @else 
            <p>Please verify your BVN in the Profile section to receive a virtual bank account.</p>
            <button class="mdc" onclick="sv('profile',null)">Go to Profile</button>
        @endif
        <button class="mdc" onclick="cm()" style="margin-top:10px">Close</button>
    </div>
</div>

<div class="mo" id="mo-verify" onclick="cm(event)">
    <div class="md">
        <div class="mdi">⚠️</div>
        <h3>Notice</h3>
        <p>This service is currently under maintenance or requires full account verification. Please contact support@codedragon.ng</p>
        <button class="mdc" onclick="cm()">Got it</button>
    </div>
</div>
