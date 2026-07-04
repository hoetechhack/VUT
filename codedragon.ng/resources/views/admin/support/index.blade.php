<x-app-layout>
    <x-slot name="header">Support Tickets</x-slot>

    @if(session('status'))
        <div style="background:rgba(34,197,94,0.1); border:1px solid #22c55e; color:#22c55e; padding:1rem; border-radius:12px; margin-bottom:1.5rem; font-size:.85rem; font-weight:600">
            ✅ {{ session('status') }}
        </div>
    @endif

    <div style="display:flex; flex-direction:column; gap:1.5rem;">
        @forelse($tickets as $ticket)
            <div class="fc" style="padding:0; overflow:hidden;">
                <div style="padding:1.5rem; border-bottom:1px solid var(--gb); display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <h3 class="ftit" style="margin-bottom:5px;">{{ $ticket->subject }}</h3>
                        <div style="font-size:0.8rem; color:var(--muted);">From: {{ $ticket->user->name }} • {{ $ticket->created_at->diffForHumans() }}</div>
                    </div>
                    <span class="txs" style="background:{{ $ticket->status === 'open' ? 'rgba(239,68,68,0.1)' : ($ticket->status === 'replied' ? 'rgba(59,130,246,0.1)' : 'rgba(255,255,255,0.05)') }}; color:{{ $ticket->status === 'open' ? '#f87171' : ($ticket->status === 'replied' ? '#60a5fa' : 'var(--muted)') }};">
                        {{ strtoupper($ticket->status) }}
                    </span>
                </div>
                <div style="padding:1.5rem;">
                    <div style="background:rgba(255,255,255,0.03); padding:1rem; border-radius:12px; border:1px solid var(--gb); margin-bottom:1.5rem; font-size:0.9rem;">
                        {{ $ticket->message }}
                    </div>

                    @if($ticket->admin_reply)
                        <div style="background:rgba(139,92,246,0.05); padding:1rem; border-radius:12px; border:1px solid rgba(139,92,246,0.2); margin-bottom:1.5rem; font-size:0.9rem;">
                            <div style="font-size:10px; font-weight:800; color:var(--purple); text-transform:uppercase; margin-bottom:5px;">Admin Reply:</div>
                            {{ $ticket->admin_reply }}
                        </div>
                    @endif

                    @if($ticket->status !== 'closed')
                        <form action="{{ route('admin.support.reply', $ticket) }}" method="POST">
                            @csrf
                            <textarea name="admin_reply" rows="3" class="fctl" style="font-size:0.9rem;" placeholder="Type your reply..."></textarea>
                            <div style="margin-top:15px; display:flex; gap:10px;">
                                <button type="submit" class="bsub" style="width:auto; padding:0 2rem;">Send Reply</button>
                                <button type="button" onclick="document.getElementById('close-form-{{ $ticket->id }}').submit()" class="wbtn">Close Ticket</button>
                            </div>
                        </form>
                        <form id="close-form-{{ $ticket->id }}" action="{{ route('admin.support.close', $ticket) }}" method="POST" style="display:none;">@csrf</form>
                    @endif
                </div>
            </div>
        @empty
            <div class="fc" style="text-align:center; padding:4rem; color:var(--muted);">
                <div style="font-size:3rem; margin-bottom:1rem;">🎉</div>
                <div>No active support tickets. All users are happy!</div>
            </div>
        @endforelse
    </div>

    <div style="margin-top:1.5rem;">
        {{ $tickets->links() }}
    </div>
</x-app-layout>
