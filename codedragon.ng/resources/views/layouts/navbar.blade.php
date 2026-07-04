@php
    $v = request('v', 'dashboard');
@endphp

<header class="topbar">
    <div class="tl">
        <div class="hb" onclick="toggleDrawer()"><span></span><span></span><span></span></div>
        <a href="{{ route('dashboard') }}" class="no-underline"><x-logo height="34" /></a>
    </div>
    <div class="tc"><span class="pt">{{ $title ?? 'Dashboard' }}</span></div>
    <div class="tr">
        <div class="ib" title="Notifications">🔔</div>
        <form method="POST" action="{{ route('logout') }}" id="logout-form-top" style="display: none;">
            @csrf
        </form>
        <div class="ib" onclick="event.preventDefault(); document.getElementById('logout-form-top').submit();" title="Logout">🚪</div>
    </div>
</header>

<nav class="tabrow">
    @if(request()->routeIs('dashboard'))
        <button class="tabi {{ $v == 'dashboard' ? 'active' : '' }}" onclick="sv('dashboard',this)"><span class="nic">🏠</span> Dashboard</button>
        <button class="tabi {{ $v == 'airtime' ? 'active' : '' }}" onclick="sv('airtime',this)"><span class="nic">📱</span> Airtime</button>
        <button class="tabi {{ $v == 'data' ? 'active' : '' }}" onclick="sv('data',this)"><span class="nic">📡</span> Data</button>
        <button class="tabi {{ $v == 'electricity' ? 'active' : '' }}" onclick="sv('electricity',this)"><span class="nic">⚡</span> Electricity</button>
        <button class="tabi {{ $v == 'cable' ? 'active' : '' }}" onclick="sv('cable',this)"><span class="nic">📺</span> Cable TV</button>
        <button class="tabi {{ $v == 'exampins' ? 'active' : '' }}" onclick="sv('exampins',this)"><span class="nic">🎓</span> Exam Pins</button>
        <button class="tabi {{ $v == 'transactions' ? 'active' : '' }}" onclick="sv('transactions',this)"><span class="nic">📋</span> Transactions</button>
        <button class="tabi {{ $v == 'subscriptions' ? 'active' : '' }}" onclick="sv('subscriptions',this)"><span class="nic">🔄</span> Recurring</button>
        <button class="tabi {{ $v == 'support' ? 'active' : '' }}" onclick="sv('support',this)"><span class="nic">💬</span> Complaints</button>
        <button class="tabi {{ $v == 'profile' ? 'active' : '' }}" onclick="sv('profile',this)"><span class="nic">👤</span> Profile</button>
    @else
        <a href="{{ route('dashboard') }}" class="tabi {{ $v == 'dashboard' ? 'active' : '' }}"><span class="nic">🏠</span> Dashboard</a>
        <a href="{{ route('profile.edit') }}" class="tabi {{ request()->routeIs('profile.*') ? 'active' : '' }}"><span class="nic">👤</span> My Profile</a>
    @endif
    @if(auth()->user()->is_admin)
        <a href="{{ route('admin.settings') }}" class="tabi {{ request()->routeIs('admin.settings') ? 'active' : '' }}"><span class="nic">⚙️</span> Settings</a>
        <a href="{{ route('admin.atc.index') }}" class="tabi {{ request()->routeIs('admin.atc.*') ? 'active' : '' }}"><span class="nic">💰</span> Airtime2Cash</a>
        <a href="{{ route('admin.pricing.index') }}" class="tabi {{ request()->routeIs('admin.pricing.*') ? 'active' : '' }}"><span class="nic">📈</span> Pricing</a>
        <a href="{{ route('admin.users.index') }}" class="tabi {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><span class="nic">👥</span> Users</a>
        <a href="{{ route('admin.support.index') }}" class="tabi {{ request()->routeIs('admin.support.*') ? 'active' : '' }}"><span class="nic">🎧</span> Support</a>
    @endif
</nav>

<div class="drawer-overlay" id="drawerOverlay" onclick="toggleDrawer()"></div>
<aside class="drawer" id="drawer">
    <div class="dh">
        <x-logo height="42" />
        <button class="dclose" onclick="toggleDrawer()">✕</button>
    </div>
    <div class="dnav">
        <div class="nl">Main</div>
        @if(request()->routeIs('dashboard'))
            <button class="ni {{ $v == 'dashboard' ? 'active' : '' }}" onclick="sv('dashboard',this);toggleDrawer()"><span class="nic">🏠</span> Dashboard</button>
            <button class="ni {{ $v == 'airtime' ? 'active' : '' }}" onclick="sv('airtime',this);toggleDrawer()"><span class="nic">📱</span> Buy Airtime</button>
            <button class="ni {{ $v == 'data' ? 'active' : '' }}" onclick="sv('data',this);toggleDrawer()"><span class="nic">📡</span> Buy Data</button>
            <button class="ni {{ $v == 'electricity' ? 'active' : '' }}" onclick="sv('electricity',this);toggleDrawer()"><span class="nic">⚡</span> Electricity</button>
            <button class="ni {{ $v == 'cable' ? 'active' : '' }}" onclick="sv('cable',this);toggleDrawer()"><span class="nic">📺</span> Cable TV</button>
            <button class="ni {{ $v == 'exampins' ? 'active' : '' }}" onclick="sv('exampins',this);toggleDrawer()"><span class="nic">🎓</span> Exam Pins</button>
        @else
            <a href="{{ route('dashboard') }}" class="ni {{ $v == 'dashboard' ? 'active' : '' }}"><span class="nic">🏠</span> Dashboard</a>
            <a href="{{ route('dashboard', ['v' => 'airtime']) }}" class="ni {{ $v == 'airtime' ? 'active' : '' }}"><span class="nic">📱</span> Buy Airtime</a>
            <a href="{{ route('dashboard', ['v' => 'data']) }}" class="ni {{ $v == 'data' ? 'active' : '' }}"><span class="nic">📡</span> Buy Data</a>
            <a href="{{ route('dashboard', ['v' => 'electricity']) }}" class="ni {{ $v == 'electricity' ? 'active' : '' }}"><span class="nic">⚡</span> Electricity</a>
            <a href="{{ route('dashboard', ['v' => 'cable']) }}" class="ni {{ $v == 'cable' ? 'active' : '' }}"><span class="nic">📺</span> Cable TV</a>
            <a href="{{ route('dashboard', ['v' => 'exampins']) }}" class="ni {{ $v == 'exampins' ? 'active' : '' }}"><span class="nic">🎓</span> Exam Pins</a>
        @endif

        <div class="nl">Account</div>
        @if(request()->routeIs('dashboard'))
            <button class="ni {{ $v == 'transactions' ? 'active' : '' }}" onclick="sv('transactions',this);toggleDrawer()"><span class="nic">📋</span> Transactions</button>
            <button class="ni {{ $v == 'subscriptions' ? 'active' : '' }}" onclick="sv('subscriptions',this);toggleDrawer()"><span class="nic">🔄</span> Recurring</button>
            <button class="ni {{ $v == 'support' ? 'active' : '' }}" onclick="sv('support',this);toggleDrawer()"><span class="nic">💬</span> Complaints</button>
            <button class="ni {{ $v == 'profile' ? 'active' : '' }}" onclick="sv('profile',this);toggleDrawer()"><span class="nic">👤</span> Profile</button>
        @else
            <a href="{{ route('profile.edit') }}" class="ni {{ request()->routeIs('profile.*') ? 'active' : '' }}"><span class="nic">👤</span> My Profile</a>
        @endif

        @if(auth()->user()->is_admin)
            <div class="nl">Administration</div>
            <a href="{{ route('admin.settings') }}" class="ni {{ request()->routeIs('admin.settings') ? 'active' : '' }}"><span class="nic">⚙️</span> Settings</a>
            <a href="{{ route('admin.atc.index') }}" class="ni {{ request()->routeIs('admin.atc.*') ? 'active' : '' }}"><span class="nic">💰</span> Airtime2Cash</a>
            <a href="{{ route('admin.pricing.index') }}" class="ni {{ request()->routeIs('admin.pricing.*') ? 'active' : '' }}"><span class="nic">📈</span> Pricing</a>
            <a href="{{ route('admin.users.index') }}" class="ni {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><span class="nic">👥</span> Users</a>
            <a href="{{ route('admin.support.index') }}" class="ni {{ request()->routeIs('admin.support.*') ? 'active' : '' }}"><span class="nic">🎧</span> Support</a>
        @endif
    </div>
    <div class="sf">
        <div class="uc">
            <div class="ua">{{ collect(explode(' ', auth()->user()->name))->map(fn($n) => mb_substr($n, 0, 1))->join('') }}</div>
            <div>
                <div class="un">{{ auth()->user()->name }}</div>
                <div class="ue" style="max-width: 140px; overflow: hidden; text-overflow: ellipsis;">{{ auth()->user()->email }}</div>
            </div>
        </div>
    </div>
</aside>
