<x-app-layout>
    <x-slot name="header">System-Wide Broadcast Alerts</x-slot>

    @if(session('status'))
        <div style="background:rgba(34,197,94,0.1); border:1px solid #22c55e; color:#22c55e; padding:1rem; border-radius:12px; margin-bottom:1.5rem; font-size:.85rem; font-weight:600">
            ✅ {{ session('status') }}
        </div>
    @endif

    <div class="fc">
        <div class="ftit">🚀 Send WhatsApp Broadcast</div>
        
        <form action="{{ route('admin.broadcast.send') }}" method="POST">
            @csrf
            
            <div class="fg" style="max-width:500px;">
                <label class="fl">Target Audience</label>
                <select name="target" class="fctl">
                    <option value="all">All Users (with phone numbers)</option>
                    <option value="verified">Verified Users Only</option>
                    <option value="unverified">Unverified Users Only</option>
                </select>
            </div>

            <div class="fg">
                <label class="fl">Message Content</label>
                <textarea name="message" rows="6" class="fctl" placeholder="Type your WhatsApp message here... Use *bold* and _italics_." required></textarea>
                <p style="font-size:11px; color:var(--muted); margin-top:8px;">Note: Messages are sent individually via the configured WhatsApp provider.</p>
            </div>

            <div style="margin-top:2rem;">
                <button type="submit" class="bsub" style="width:auto; padding:0 3rem; height:55px;">
                    📢 Launch Broadcast
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
