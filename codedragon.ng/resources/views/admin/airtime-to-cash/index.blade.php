<x-app-layout>
    <x-slot name="header">Airtime-to-Cash Management</x-slot>

    @if(session('status'))
        <div style="background:rgba(34,197,94,0.1); border:1px solid #22c55e; color:#22c55e; padding:1rem; border-radius:12px; margin-bottom:1.5rem; font-size:.85rem; font-weight:600">
            ✅ {{ session('status') }}
        </div>
    @endif

    <div class="fc" style="padding:0; overflow:hidden;">
        <div style="padding:1.5rem; border-bottom:1px solid var(--gb); display:flex; justify-content:space-between; align-items:center;">
            <h3 class="ftit" style="margin-bottom:0;">Conversion Requests</h3>
            <div style="font-size:0.8rem; color:var(--muted);">Showing {{ $requests->count() }} requests</div>
        </div>

        <div class="txl">
            @forelse($requests as $atc)
                <div class="txi" style="border-radius:0; border:none; border-bottom:1px solid var(--gb); background:transparent; padding:1.5rem;">
                    <div class="txin">
                        <div class="txt">{{ strtoupper($atc->network) }} - ₦{{ number_format($atc->amount, 2) }}</div>
                        <div class="txd">From: {{ $atc->phone }} (User: {{ $atc->user->name }})</div>
                        <div class="txd" style="color:var(--green); font-weight:700; margin-top:5px;">Credit Amount: ₦{{ number_format($atc->receive_amount, 2) }}</div>
                        <div class="txd" style="font-family:monospace; font-size:10px; margin-top:5px;">Ref: {{ $atc->reference }} • {{ $atc->created_at->format('d M, H:i') }}</div>
                    </div>
                    
                    <div style="display:flex; flex-direction:column; gap:10px; align-items:flex-end;">
                        <span class="txs" style="background:{{ $atc->status === 'approved' ? 'rgba(34,197,94,0.1)' : ($atc->status === 'rejected' ? 'rgba(239,68,68,0.1)' : 'rgba(251,191,36,0.1)') }}; color:{{ $atc->status === 'approved' ? '#4ade80' : ($atc->status === 'rejected' ? '#f87171' : '#fbbf24') }};">
                            {{ strtoupper($atc->status) }}
                        </span>
                        
                        @if($atc->status === 'pending')
                            <div style="display:flex; gap:10px;">
                                <form action="{{ route('admin.atc.update', $atc) }}" method="POST" style="display:flex; gap:10px; align-items:center;">
                                    @csrf
                                    <input type="text" name="admin_note" placeholder="Note (optional)" class="fctl" style="width:150px; height:36px; padding:4px 8px; font-size:0.8rem;">
                                    <button type="submit" name="status" value="approved" class="wbtn" style="background:var(--green); color:white; border:none; height:36px;">Approve</button>
                                    <button type="submit" name="status" value="rejected" class="wbtn" style="background:rgba(239,68,68,0.8); color:white; border:none; height:36px;">Reject</button>
                                </form>
                            </div>
                        @else
                            <div class="txd" style="font-size:0.75rem; color:var(--muted); font-style:italic;">Note: {{ $atc->admin_note ?? 'None' }}</div>
                        @endif
                    </div>
                </div>
            @empty
                <div style="padding:4rem; text-align:center; color:var(--muted);">
                    <div style="font-size:3rem; margin-bottom:1rem;">☕</div>
                    <div>No pending requests. Everything is processed!</div>
                </div>
            @endforelse
        </div>

        <div style="padding:1rem;">
            {{ $requests->links() }}
        </div>
    </div>
</x-app-layout>
