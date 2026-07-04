<x-app-layout>
    <x-slot name="header">User Details: {{ $user->name }}</x-slot>

    @if(session('status'))
        <div style="background:rgba(34,197,94,0.1); border:1px solid #22c55e; color:#22c55e; padding:1rem; border-radius:12px; margin-bottom:1.5rem; font-size:.85rem; font-weight:600">
            ✅ {{ session('status') }}
        </div>
    @endif

    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap:1.5rem; margin-bottom:1.5rem;">
        <!-- Profile -->
        <div class="fc">
            <div class="ftit">👤 Profile Details</div>
            <div style="display:flex; flex-direction:column; gap:12px;">
                <div style="display:flex; justify-content:space-between;"><span style="color:var(--muted);">Full Name</span><span style="font-weight:700;">{{ $user->name }}</span></div>
                <div style="display:flex; justify-content:space-between;"><span style="color:var(--muted);">Email</span><span style="font-weight:700;">{{ $user->email }}</span></div>
                <div style="display:flex; justify-content:space-between;"><span style="color:var(--muted);">BVN</span><span style="font-weight:700;">{{ $user->bvn ?: 'Not set' }}</span></div>
                <div style="display:flex; justify-content:space-between;">
                    <span style="color:var(--muted);">Verification</span>
                    <span class="txs {{ $user->is_verified ? 'ss' : 'sp' }}">{{ $user->is_verified ? 'VERIFIED' : 'PENDING' }}</span>
                </div>
                <div style="display:flex; justify-content:space-between;">
                    <span style="color:var(--muted);">Status</span>
                    <span class="txs {{ $user->is_active ? 'ss' : 'sp' }}" style="background:{{ $user->is_active ? 'rgba(34,197,94,0.1)' : 'rgba(239,68,68,0.1)' }}; color:{{ $user->is_active ? '#4ade80' : '#f87171' }};">
                        {{ $user->is_active ? 'ACTIVE' : 'SUSPENDED' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Financials -->
        <div class="fc">
            <div class="ftit">💰 Financial Stats</div>
            <div style="display:flex; flex-direction:column; gap:20px;">
                <div>
                    <div style="font-size:11px; color:var(--muted); text-transform:uppercase; font-weight:800;">Wallet Balance</div>
                    <div style="font-size:2rem; font-weight:900; color:var(--purple);">₦{{ number_format($walletBalance, 2) }}</div>
                </div>
                <div>
                    <div style="font-size:11px; color:var(--muted); text-transform:uppercase; font-weight:800;">Total Spend</div>
                    <div style="font-size:1.5rem; font-weight:800; color:#fff;">₦{{ number_format($totalSpend, 2) }}</div>
                </div>
                @if($user->wallet && $user->wallet->virtual_account_number)
                    <div style="background:rgba(255,255,255,0.03); padding:10px; border-radius:10px; border:1px solid var(--gb);">
                        <div style="font-size:10px; color:var(--muted);">VIRTUAL ACCOUNT</div>
                        <div style="font-size:0.9rem; font-weight:700;">{{ $user->wallet->virtual_bank_name }} - {{ $user->wallet->virtual_account_number }}</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="fc">
            <div class="ftit">🛠️ Account Actions</div>
            <div style="display:flex; flex-direction:column; gap:12px;">
                <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST">
                    @csrf
                    <button type="submit" class="bsub" style="background:{{ $user->is_active ? 'rgba(239,68,68,0.8)' : 'var(--green)' }};">
                        {{ $user->is_active ? 'Suspend Account' : 'Activate Account' }}
                    </button>
                </form>

                @if($user->is_verified)
                    <form action="{{ route('admin.users.unverify', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="wbtn" style="width:100%;">Unverify Account</button>
                    </form>
                @else
                    <form action="{{ route('admin.users.verify', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="bsub">Verify Account</button>
                    </form>
                @endif

                <div style="margin-top:10px; padding-top:15px; border-top:1px solid var(--gb);">
                    <div class="ftit" style="font-size:0.8rem;">Manual Fund Wallet</div>
                    <form action="{{ route('admin.users.add-balance', $user) }}" method="POST" style="display:flex; gap:10px;">
                        @csrf
                        <input type="number" name="amount" placeholder="Amount (₦)" required class="fctl" style="height:36px; font-size:0.85rem;">
                        <button type="submit" class="bsub" style="height:36px; margin-top:0; width:100px;">Fund</button>
                    </form>
                </div>

                <div style="margin-top:10px; padding-top:15px; border-top:1px solid var(--gb);">
                    <div class="ftit" style="font-size:0.8rem;">Change Password</div>
                    <form action="{{ route('admin.users.update-password', $user) }}" method="POST" style="display:flex; flex-direction:column; gap:10px;">
                        @csrf
                        <input type="password" name="password" placeholder="New Password" class="fctl" style="height:36px; font-size:0.85rem;">
                        <input type="password" name="password_confirmation" placeholder="Confirm" class="fctl" style="height:36px; font-size:0.85rem;">
                        <button type="submit" class="wbtn" style="width:100%;">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="fc" style="padding:0; overflow:hidden;">
        <div style="padding:1.25rem; border-bottom:1px solid var(--gb); font-weight:700;">Transaction History</div>
        <div class="txl">
            @forelse($transactions as $tx)
                <div class="txi" style="border-radius:0; border:none; border-bottom:1px solid var(--gb); background:transparent;">
                    <div class="txic" style="background:var(--cb)">{{ $tx->type === 'funding' ? '💳' : '🛒' }}</div>
                    <div class="txin">
                        <div class="txt">{{ $tx->reference }}</div>
                        <div class="txd">{{ ucfirst($tx->type) }} • {{ $tx->created_at->format('d M, H:i') }}</div>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-weight:800; font-size:0.95rem;">₦{{ number_format($tx->amount, 2) }}</div>
                        <span class="txs {{ $tx->status === 'success' ? 'ss' : 'sp' }}">{{ strtoupper($tx->status) }}</span>
                    </div>
                </div>
            @empty
                <div style="padding:3rem; text-align:center; color:var(--muted);">No transactions found.</div>
            @endforelse
        </div>
        <div style="padding:1rem;">{{ $transactions->links() }}</div>
    </div>
</x-app-layout>
