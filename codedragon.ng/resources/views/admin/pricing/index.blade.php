<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; justify-content:space-between; align-items:center; width:100%;">
            <span>Pricing & Commission Engine</span>
            <form action="{{ route('admin.pricing.sync') }}" method="POST">
                @csrf
                <button type="submit" class="wbtn" style="background:var(--purple); border:none;">🔄 Sync Wholesale Prices</button>
            </form>
        </div>
    </x-slot>

    @if(session('status'))
        <div style="background:rgba(34,197,94,0.1); border:1px solid #22c55e; color:#22c55e; padding:1rem; border-radius:12px; margin-bottom:1.5rem; font-size:.85rem; font-weight:600">
            ✅ {{ session('status') }}
        </div>
    @endif

    <div style="display:grid; grid-template-columns: 240px 1fr; gap:1.5rem;">
        <!-- Categories Sidebar -->
        <div class="fc" style="padding:0; align-self:start;">
            <div style="padding:1rem; border-bottom:1px solid var(--gb); font-weight:700; font-size:0.8rem; color:var(--muted); text-transform:uppercase;">Categories</div>
            <div class="txl">
                @foreach($services as $service)
                    <a href="{{ route('admin.pricing.index', ['service' => $service]) }}" 
                       style="display:block; padding:12px 16px; text-decoration:none; color:{{ $selectedService == $service ? '#fff' : 'var(--muted)' }}; background:{{ $selectedService == $service ? 'rgba(124,58,237,0.1)' : 'transparent' }}; border-left:3px solid {{ $selectedService == $service ? 'var(--purple)' : 'transparent' }}; font-weight:{{ $selectedService == $service ? '700' : '500' }}; font-size:0.85rem;">
                        {{ strtoupper(str_replace('-', ' ', $service)) }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Main Pricing Area -->
        <div style="display:flex; flex-direction:column; gap:1.5rem;">
            <!-- Rule Engine -->
            <div class="fc" style="background:rgba(139,92,246,0.05); border:1px solid rgba(139,92,246,0.2);">
                <div class="ftit" style="font-size:1rem;">Universal Rule for {{ strtoupper(str_replace('-', ' ', $selectedService)) }}</div>
                <form action="{{ route('admin.pricing.rule') }}" method="POST" style="display:grid; grid-template-columns: 1fr 1fr 150px; gap:1rem; align-items:flex-end;">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $selectedService }}">
                    <div class="fg">
                        <label class="fl">Rule Type</label>
                        <select name="rule_type" class="fctl">
                            <option value="percentage">Percentage Markup (%)</option>
                            <option value="fixed">Fixed Rate Markup (₦)</option>
                        </select>
                    </div>
                    <div class="fg">
                        <label class="fl">Value</label>
                        <input type="number" step="0.01" name="rule_value" placeholder="e.g. 5" required class="fctl">
                    </div>
                    <button type="submit" class="bsub" style="height:48px;">Apply</button>
                </form>
            </div>

            <!-- Variations -->
            <div class="fc" style="padding:0;">
                <div style="padding:1.25rem; border-bottom:1px solid var(--gb); font-weight:700;">Package Overrides</div>
                <div class="txl">
                    @forelse($variations as $var)
                        <div class="txi" style="border-radius:0; border:none; border-bottom:1px solid var(--gb); background:transparent; padding:1.25rem;">
                            <div class="txin">
                                <div class="txt">{{ $var->name }}</div>
                                <div class="txd">Code: {{ $var->variation_code }} • Wholesale: ₦{{ number_format($var->wholesale_price, 2) }}</div>
                            </div>
                            <form action="{{ route('admin.pricing.manual', $var->id) }}" method="POST" style="display:flex; gap:15px; align-items:center;">
                                @csrf
                                <div style="width:120px;">
                                    <label style="font-size:9px; color:var(--muted); text-transform:uppercase; display:block; margin-bottom:4px; font-weight:800;">Retail Price</label>
                                    <input type="number" step="0.01" name="retail_price" value="{{ $var->retail_price ?? $var->wholesale_price }}" class="fctl" style="padding:4px 8px; font-size:0.85rem; height:36px;">
                                </div>
                                <div style="width:110px;">
                                    <label style="font-size:9px; color:var(--muted); text-transform:uppercase; display:block; margin-bottom:4px; font-weight:800;">Category</label>
                                    <select name="category" class="fctl" style="padding:4px 8px; font-size:0.75rem; height:36px;">
                                        <option value="">Auto</option>
                                        <option value="daily" {{ $var->category == 'daily' ? 'selected' : '' }}>Daily</option>
                                        <option value="weekly" {{ $var->category == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                        <option value="monthly" {{ $var->category == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                        <option value="others" {{ $var->category == 'others' ? 'selected' : '' }}>Others</option>
                                    </select>
                                </div>
                                <div style="display:flex; flex-direction:column; align-items:center;">
                                    <label style="font-size:9px; color:var(--fuchsia); text-transform:uppercase; display:block; margin-bottom:4px; font-weight:800;">Hot Deal</label>
                                    <input type="checkbox" name="is_hot_deal" value="1" {{ $var->is_hot_deal ? 'checked' : '' }} style="width:20px; height:20px; accent-color:var(--fuchsia);">
                                </div>
                                <div style="width:140px;">
                                    <label style="font-size:9px; color:var(--muted); text-transform:uppercase; display:block; margin-bottom:4px; font-weight:800;">Start Date</label>
                                    <input type="datetime-local" name="hot_deal_start" value="{{ $var->hot_deal_start ? $var->hot_deal_start->format('Y-m-d\TH:i') : '' }}" class="fctl" style="padding:4px 8px; font-size:0.75rem; height:36px;">
                                </div>
                                <div style="width:140px;">
                                    <label style="font-size:9px; color:var(--muted); text-transform:uppercase; display:block; margin-bottom:4px; font-weight:800;">End Date</label>
                                    <input type="datetime-local" name="hot_deal_end" value="{{ $var->hot_deal_end ? $var->hot_deal_end->format('Y-m-d\TH:i') : '' }}" class="fctl" style="padding:4px 8px; font-size:0.75rem; height:36px;">
                                </div>
                                <button type="submit" class="wbtn" style="height:36px; align-self:flex-end;">Save</button>
                            </form>
                        </div>
                    @empty
                        <div style="padding:3rem; text-align:center; color:var(--muted);">No packages found. Click Sync.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
