<x-app-layout>
    <x-slot name="header">Admin Settings & API Keys</x-slot>

    @if(session('status'))
        <div style="background:rgba(34,197,94,0.1); border:1px solid #22c55e; color:#22c55e; padding:1rem; border-radius:12px; margin-bottom:1.5rem; font-size:.85rem; font-weight:600">
            ✅ {{ session('status') }}
        </div>
    @endif

    @if(auth()->user()->email === 'info@codedragon.ng')
    <div class="fc">
        <div class="ftit">💼 Business Financials <span style="font-size:10px; background:var(--purple); color:white; padding:2px 8px; border-radius:100px; margin-left:10px;">SUPER ADMIN</span></div>
        
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1.25rem; margin-bottom:1.5rem;">
            <div style="background:rgba(139,92,246,0.1); padding:1.5rem; border-radius:15px; border:1px solid rgba(139,92,246,0.2)">
                <div style="font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase;">Monnify Wallet</div>
                <div style="font-size:1.8rem; font-weight:900; color:#fff; margin-top:5px;">₦{{ is_numeric($monnifyBalance) ? number_format($monnifyBalance, 2) : $monnifyBalance }}</div>
            </div>
            <div style="background:rgba(34,197,94,0.1); padding:1.5rem; border-radius:15px; border:1px solid rgba(34,197,94,0.2)">
                <div style="font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase;">VTPass Wallet</div>
                <div style="font-size:1.8rem; font-weight:900; color:#fff; margin-top:5px;">₦{{ is_numeric($vtpassBalance) ? number_format($vtpassBalance, 2) : $vtpassBalance }}</div>
            </div>
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1.5rem;">
            <div>
                <div class="ftit" style="font-size:0.9rem; margin-bottom:0.5rem;">Manual Fund VTPass</div>
                <form action="{{ route('admin.settings.fund-vtpass') }}" method="POST">
                    @csrf
                    <div style="display:flex; gap:10px;">
                        <input type="number" name="amount" placeholder="Amount (₦)" required class="fctl">
                        <button type="submit" class="bsub" style="width:auto; padding:0 1.5rem;">Transfer</button>
                    </div>
                </form>
            </div>
            <div>
                <div class="ftit" style="font-size:0.9rem; margin-bottom:0.5rem;">Auto-Top-Up</div>
                <form action="{{ route('admin.settings.store') }}" method="POST">
                    @csrf
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                        <input type="number" name="vtpass_auto_fund_threshold" value="{{ $settings['vtpass_auto_fund_threshold'] ?? '' }}" placeholder="Threshold" class="fctl">
                        <input type="number" name="vtpass_auto_fund_amount" value="{{ $settings['vtpass_auto_fund_amount'] ?? '' }}" placeholder="Amount" class="fctl">
                    </div>
                    <button type="submit" class="wbtn" style="width:100%; margin-top:10px;">Save Rules</button>
                </form>
            </div>
        </div>
    </div>
    @endif

    <div class="fc">
        <div class="ftit">⚙️ API Configurations</div>
        
        <form action="{{ route('admin.settings.store') }}" method="POST">
            @csrf
            
            <div class="fg" style="background:rgba(59,130,246,0.1); padding:1rem; border-radius:12px; border:1px solid rgba(59,130,246,0.2); margin-bottom:20px;">
                <label class="fl" style="color:#60a5fa;">Platform Environment</label>
                <select name="platform_environment" class="fctl">
                    <option value="sandbox" {{ ($settings['platform_environment'] ?? 'sandbox') === 'sandbox' ? 'selected' : '' }}>Sandbox Mode (Testing)</option>
                    <option value="live" {{ ($settings['platform_environment'] ?? 'sandbox') === 'live' ? 'selected' : '' }}>Live Mode (Production)</option>
                </select>
            </div>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1.5rem;">
                <div>
                    <div class="ftit" style="font-size:0.9rem; margin-bottom:1rem; border-bottom:1px solid var(--gb); padding-bottom:5px;">VTPass API</div>
                    <div class="fg"><label class="fl">Email</label><input type="text" name="vtpass_username" value="{{ $settings['vtpass_username'] ?? '' }}" class="fctl"></div>
                    <div class="fg"><label class="fl">Password</label><input type="password" name="vtpass_password" value="{{ $settings['vtpass_password'] ?? '' }}" class="fctl"></div>
                    <div class="fg"><label class="fl">Public Key</label><input type="text" name="vtpass_public_key" value="{{ $settings['vtpass_public_key'] ?? '' }}" class="fctl"></div>
                    <div class="fg"><label class="fl">Secret Key</label><input type="password" name="vtpass_secret_key" value="{{ $settings['vtpass_secret_key'] ?? '' }}" class="fctl"></div>
                </div>
                <div>
                    <div class="ftit" style="font-size:0.9rem; margin-bottom:1rem; border-bottom:1px solid var(--gb); padding-bottom:5px;">Monnify API</div>
                    <div class="fg"><label class="fl">API Key</label><input type="text" name="monnify_api_key" value="{{ $settings['monnify_api_key'] ?? '' }}" class="fctl"></div>
                    <div class="fg"><label class="fl">Secret Key</label><input type="password" name="monnify_secret_key" value="{{ $settings['monnify_secret_key'] ?? '' }}" class="fctl"></div>
                    <div class="fg"><label class="fl">Contract Code</label><input type="text" name="monnify_contract_code" value="{{ $settings['monnify_contract_code'] ?? '' }}" class="fctl"></div>
                    <div class="fg"><label class="fl">Base URL</label><input type="text" name="monnify_base_url" value="{{ $settings['monnify_base_url'] ?? 'https://sandbox.monnify.com' }}" class="fctl"></div>
                </div>
            </div>

            <div style="margin-top:20px;">
                <div class="ftit" style="font-size:0.9rem; margin-bottom:1rem; border-bottom:1px solid var(--gb); padding-bottom:5px;">WhatsApp & Commissions</div>
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1.5rem;">
                    <div>
                        <div class="fg"><label class="fl">WhatsApp Provider</label>
                            <select name="whatsapp_provider" class="fctl">
                                <option value="none" {{ ($settings['whatsapp_provider'] ?? 'none') === 'none' ? 'selected' : '' }}>None (Disabled)</option>
                                <option value="termii" {{ ($settings['whatsapp_provider'] ?? '') === 'termii' ? 'selected' : '' }}>Termii</option>
                                <option value="sendchamp" {{ ($settings['whatsapp_provider'] ?? '') === 'sendchamp' ? 'selected' : '' }}>Sendchamp</option>
                            </select>
                        </div>
                        <div class="fg"><label class="fl">API Key</label><input type="password" name="whatsapp_api_key" value="{{ $settings['whatsapp_api_key'] ?? '' }}" class="fctl"></div>
                    </div>
                    <div>
                        <div class="fg"><label class="fl">Referral Commission (₦)</label><input type="number" step="0.01" name="referral_commission" value="{{ $settings['referral_commission'] ?? '0' }}" class="fctl"></div>
                        <div class="fg"><label class="fl">Airtime-to-Cash (%)</label><input type="number" step="1" name="airtime_to_cash_commission" value="{{ $settings['airtime_to_cash_commission'] ?? '20' }}" class="fctl"></div>
                    </div>
                </div>
            </div>

            <div style="margin-top:2rem; display:flex; justify-content:flex-end;">
                <button type="submit" class="bsub" style="width:auto; padding:0 3rem; height:55px; font-size:1.1rem;">💾 Save All Settings</button>
            </div>
        </form>
    </div>
</x-app-layout>
