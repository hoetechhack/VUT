<x-app-layout>
    <x-slot name="header">User Management</x-slot>

    @if(session('status'))
        <div style="background:rgba(34,197,94,0.1); border:1px solid #22c55e; color:#22c55e; padding:1rem; border-radius:12px; margin-bottom:1.5rem; font-size:.85rem; font-weight:600">
            ✅ {{ session('status') }}
        </div>
    @endif

    <div class="fc" style="padding:0; overflow:hidden;">
        <div style="padding:1.5rem; border-bottom:1px solid var(--gb); display:flex; justify-content:space-between; align-items:center;">
            <h3 class="ftit" style="margin-bottom:0;">Registered Users</h3>
            <div style="font-size:0.8rem; color:var(--muted);">Total: {{ $users->total() }} users</div>
        </div>

        <div class="txl">
            @foreach($users as $user)
                <div class="txi" style="border-radius:0; border:none; border-bottom:1px solid var(--gb); background:transparent;">
                    <div class="ua" style="width:40px; height:40px; font-size:0.9rem;">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    <div class="txin">
                        <div class="txt">{{ $user->name }} @if($user->is_admin) <span style="font-size:10px; background:var(--purple); color:white; padding:1px 6px; border-radius:4px; margin-left:5px;">ADMIN</span> @endif</div>
                        <div class="txd">{{ $user->email }} • Joined {{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</div>
                    </div>
                    <div style="display:flex; gap:10px; align-items:center;">
                        <span class="txs {{ $user->is_active ? 'ss' : 'sp' }}" style="background:{{ $user->is_active ? 'rgba(34,197,94,0.1)' : 'rgba(239,68,68,0.1)' }}; color:{{ $user->is_active ? '#4ade80' : '#f87171' }};">
                            {{ $user->is_active ? 'ACTIVE' : 'SUSPENDED' }}
                        </span>
                        @if($user->is_verified)
                            <span class="txs ss" title="Verified">✓</span>
                        @endif
                        <a href="{{ route('admin.users.show', $user) }}" class="wbtn" style="padding:4px 12px; font-size:0.75rem;">View</a>
                        <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST">
                            @csrf
                            <button type="submit" class="wbtn" style="padding:4px 12px; font-size:0.75rem; border-color:{{ $user->is_active ? '#f87171' : 'var(--green)' }}; color:{{ $user->is_active ? '#f87171' : 'var(--green)' }};">
                                {{ $user->is_active ? 'Suspend' : 'Activate' }}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="padding:1rem;">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
