<div class="view" id="view-airtime">
    <div class="fc"><div class="ftit">📱 Buy Airtime</div>
        <form action="{{ route('purchase.buy') }}" method="POST" class="purchase-form" data-context="airtime">
            @csrf
            <div id="airtime_notification" class="purchase-notification"></div>
            <label class="fl">Select Network</label>
            <div class="data-grid" style="grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 20px;">
                <div class="data-card" onclick="sa('mtn', this)" style="min-height:80px; padding:10px; text-align:center;">
                    <div style="font-size:1.5rem">🟡</div>
                    <div style="font-size:0.7rem; font-weight:700">MTN</div>
                </div>
                <div class="data-card" onclick="sa('airtel', this)" style="min-height:80px; padding:10px; text-align:center;">
                    <div style="font-size:1.5rem">🔴</div>
                    <div style="font-size:0.7rem; font-weight:700">Airtel</div>
                </div>
                <div class="data-card" onclick="sa('glo', this)" style="min-height:80px; padding:10px; text-align:center;">
                    <div style="font-size:1.5rem">🟢</div>
                    <div style="font-size:0.7rem; font-weight:700">Glo</div>
                </div>
                <div class="data-card" onclick="sa('etisalat', this)" style="min-height:80px; padding:10px; text-align:center;">
                    <div style="font-size:1.5rem">⚪</div>
                    <div style="font-size:0.7rem; font-weight:700">9mobile</div>
                </div>
            </div>

            <input type="hidden" name="serviceID" id="airtime_service">
            <input type="hidden" name="variation_code" value="airtime">
            
            <div id="airtime_purchase_details" style="display:none; margin-top: 25px; padding-top: 25px; border-top: 1px solid var(--gb);">
                <div class="ftit" style="font-size: 0.9rem; color: var(--purple);">Step 2: Complete Your Purchase</div>
                <div class="fg"><label class="fl">Phone Number</label><input type="tel" name="phone" class="fctl" placeholder="e.g. 08012345678" maxlength="11" required></div>
                <div class="fg"><label class="fl">Amount (₦)</label><input type="number" name="amount" class="fctl" placeholder="Minimum ₦50" min="50" required></div>
                
                <div class="fg"><label class="fl">Transaction PIN</label>
                    <div class="pass-container">
                        <input type="password" name="pin" class="fctl" placeholder="4-digit PIN" maxlength="4" required autocomplete="off">
                        <button type="button" class="monkey-toggle">🙈</button>
                    </div>
                </div>
                <button type="submit" class="bsub">Buy Airtime Now</button>
            </div>
        </form>
    </div>
</div>

<div class="view" id="view-data">
    <div class="fc"><div class="ftit">📡 Buy Data Bundle</div>
        <form action="{{ route('purchase.buy') }}" method="POST" class="purchase-form" data-context="data">
            @csrf
            <div id="data_notification" class="purchase-notification"></div>
            <div class="fg"><label class="fl">Network</label>
                <select name="serviceID" class="fctl" onchange="ld(this.value)">
                    <option value="">Select Network</option>
                    <option value="mtn-data">MTN Nigeria</option>
                    <option value="airtel-data">Airtel Nigeria</option>
                    <option value="glo-data">Glo Mobile</option>
                    <option value="etisalat-data">9mobile</option>
                </select>
            </div>

            <!-- Categories Tabs -->
            <div class="tabs" id="data_tabs" style="display:none">
                <div class="tab active" onclick="filterData('hot')">🔥 Hot Deals</div>
                <div class="tab" onclick="filterData('daily')">Daily</div>
                <div class="tab" onclick="filterData('weekly')">Weekly</div>
                <div class="tab" onclick="filterData('monthly')">Monthly</div>
                <div class="tab" onclick="filterData('others')">Others</div>
            </div>

            <!-- Data Cards Grid -->
            <div class="data-grid" id="data_cards">
                <!-- Cards injected here by JS -->
            </div>

            <input type="hidden" name="variation_code" id="selected_variation">
            <input type="hidden" name="auto_renew_frequency" id="auto_renew_frequency" value="monthly">
            
            <div id="data_purchase_details" style="display:none; margin-top: 25px; padding-top: 25px; border-top: 1px solid var(--gb);">
                <div class="ftit" style="font-size: 0.9rem; color: var(--purple);">Step 2: Complete Your Purchase</div>
                <div class="fg"><label class="fl">Phone Number</label><input type="tel" name="phone" class="fctl" placeholder="e.g. 08012345678" maxlength="11" required></div>
                
                <div class="fg" style="margin-top: 15px;">
                    <div style="position:relative">
                        <input type="number" name="amount" id="data_amount" class="fctl" readonly required style="background:rgba(255,255,255,0.05)" placeholder="Select a plan above">
                        <div id="data_price_display" style="position:absolute; right:15px; top:50%; transform:translateY(-50%); font-weight:700; color:var(--purple); font-size:1rem; pointer-events:none;">₦0.00</div>
                    </div>
                </div>

                <div style="display:flex; align-items:center; gap:10px; margin: 15px 0; padding: 15px; background: rgba(185,28,28,0.1); border-radius: 12px; border: 1px solid rgba(185,28,28,0.2);">
                    <input type="checkbox" name="recurring" value="on" id="data_recurring_toggle" onchange="toggleRecurringDetails('data')" style="width: 22px; height: 22px; accent-color: var(--purple);">
                    <label for="data_recurring_toggle" style="margin: 0; font-size: 0.9rem; font-weight: 700; cursor: pointer;">Setup Recurring Payment</label>
                </div>

                <div id="data_recurring_fields" style="display:none; margin-bottom: 20px; padding: 15px; border: 1px dashed var(--gb); border-radius: 12px;">
                    <div class="fg"><label class="fl">Interval (Every X Days)</label><input type="number" name="frequency_days" class="fctl" value="30" min="1"></div>
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div class="fg"><label class="fl">Total Runs (Optional)</label><input type="number" name="max_runs" class="fctl" placeholder="e.g. 5"></div>
                        <div class="fg"><label class="fl">End Date (Optional)</label><input type="date" name="end_at" class="fctl"></div>
                    </div>
                </div>

                <div class="fg"><label class="fl">Payment Method</label>
                    <select name="payment_method" class="fctl">
                        <option value="wallet" class="wallet-balance-option">Wallet (₦{{ number_format(auth()->user()->wallet->balance ?? 0, 2) }})</option>
                        <option value="direct">Direct Bank Transfer / Card</option>
                    </select>
                </div>
                <div class="fg"><label class="fl">Transaction PIN</label>
                    <div class="pass-container">
                        <input type="password" name="pin" class="fctl" placeholder="4-digit PIN" maxlength="4" required autocomplete="off">
                        <button type="button" class="monkey-toggle">🙈</button>
                    </div>
                </div>
                <button type="submit" class="bsub">Buy Data Now</button>
            </div>
        </form>
    </div>
</div>

<div class="view" id="view-electricity">
    <div class="fc"><div class="ftit">⚡ Pay Electricity Bill</div>
        <form action="{{ route('purchase.buy') }}" method="POST" class="purchase-form" data-context="elec">
            @csrf
            <div id="elec_notification" class="purchase-notification"></div>
            <div class="fg"><label class="fl">DISCO (Provider)</label>
                <select name="serviceID" class="fctl" onchange="ld(this.value, null, 'elec')">
                    <option value="">Select Provider</option>
                    <option value="abuja-electric">AEDC – Abuja Electric</option>
                    <option value="eko-electric">EKEDC – Eko Electric</option>
                    <option value="ikeja-electric">IKEDC – Ikeja Electric</option>
                    <option value="enugu-electric">EEDC – Enugu Electric</option>
                    <option value="ibadan-electric">IBEDC – Ibadan Electric</option>
                    <option value="jos-electric">JED – Jos Electric</option>
                    <option value="kano-electric">KEDCO – Kano Electric</option>
                    <option value="port-harcourt-electric">PHED – Port Harcourt Electric</option>
                </select>
            </div>

            <div id="elec_cards_container" style="display:none">
                <label class="fl">Select Type</label>
                <div class="data-grid" id="elec_cards"></div>
            </div>

            <input type="hidden" name="variation_code" id="elec_variation">
            
            <div class="fg"><label class="fl">Meter Number</label>
                <div style="display:flex; gap:10px">
                    <input type="text" name="billersCode" id="elec_meter" class="fctl" placeholder="Enter meter number" required>
                    <button type="button" class="wbtn" onclick="vb('elec')">Verify</button>
                </div>
                <div id="elec_verify_name" style="font-size:0.75rem; margin-top:5px; color:var(--green); font-weight:700"></div>
            </div>

            <div id="elec_purchase_details" style="display:none; margin-top: 25px; padding-top: 25px; border-top: 1px solid var(--gb);">
                <div class="ftit" style="font-size: 0.9rem; color: var(--purple);">Step 3: Complete Your Payment</div>
                <div class="fg"><label class="fl">Amount (₦)</label><input type="number" name="amount" class="fctl" placeholder="Minimum ₦500" min="500" required></div>
                <div class="fg"><label class="fl">Phone Number</label><input type="tel" name="phone" class="fctl" placeholder="e.g. 08012345678" maxlength="11" required></div>

                <div class="fg"><label class="fl">Transaction PIN</label>
                    <div class="pass-container">
                        <input type="password" name="pin" class="fctl" placeholder="4-digit PIN" maxlength="4" required autocomplete="off">
                        <button type="button" class="monkey-toggle">🙈</button>
                    </div>
                </div>
                <button type="submit" class="bsub">Pay Bill Now</button>
            </div>
        </form>
    </div>
</div>

<div class="view" id="view-cable">
    <div class="fc"><div class="ftit">📺 Cable TV Subscription</div>
        <form action="{{ route('purchase.buy') }}" method="POST" class="purchase-form" data-context="cable">
            @csrf
            <div id="cable_notification" class="purchase-notification"></div>
            <div class="fg"><label class="fl">Provider</label>
                <select name="serviceID" class="fctl" onchange="ld(this.value, null, 'cable')">
                    <option value="">Select Provider</option>
                    <option value="dstv">DStv</option>
                    <option value="gotv">GOtv</option>
                    <option value="startimes">Startimes</option>
                    <option value="showmax">Showmax</option>
                </select>
            </div>

            <div id="cable_cards_container" style="display:none">
                <label class="fl">Select Package</label>
                <div class="data-grid" id="cable_cards"></div>
            </div>

            <input type="hidden" name="variation_code" id="cable_variation">
            
            <div class="fg"><label class="fl">Smart Card / IUC Number</label>
                <div style="display:flex; gap:10px">
                    <input type="text" name="billersCode" id="cable_meter" class="fctl" placeholder="Enter card number" required>
                    <button type="button" class="wbtn" onclick="vb('cable')">Verify</button>
                </div>
                <div id="cable_verify_name" style="font-size:0.75rem; margin-top:5px; color:var(--green); font-weight:700"></div>
            </div>

            <div id="cable_purchase_details" style="display:none; margin-top: 25px; padding-top: 25px; border-top: 1px solid var(--gb);">
                <div class="ftit" style="font-size: 0.9rem; color: var(--purple);">Step 3: Complete Your Subscription</div>
                <div class="fg" style="display:none" id="cable_amount_fg"><label class="fl">Amount (₦)</label><input type="number" name="amount" id="cable_amount" class="fctl" readonly></div>
                <div class="fg"><label class="fl">Phone Number</label><input type="tel" name="phone" class="fctl" placeholder="e.g. 08012345678" maxlength="11" required></div>

                <div class="fg"><label class="fl">Transaction PIN</label>
                    <div class="pass-container">
                        <input type="password" name="pin" class="fctl" placeholder="4-digit PIN" maxlength="4" required autocomplete="off">
                        <button type="button" class="monkey-toggle">🙈</button>
                    </div>
                </div>
                <button type="submit" class="bsub">Subscribe Now</button>
            </div>
        </form>
    </div>
</div>

<div class="view" id="view-exampins">
    <div class="fc"><div class="ftit">🎓 Buy Exam Pins</div>
        <form action="{{ route('purchase.buy') }}" method="POST" class="purchase-form" data-context="exam">
            @csrf
            <div id="exam_notification" class="purchase-notification"></div>
            <div class="fg"><label class="fl">Exam Body</label>
                <select name="serviceID" class="fctl" onchange="ld(this.value, null, 'exam')">
                    <option value="">Select Exam</option>
                    <option value="waec">WAEC Result Checker</option>
                    <option value="waec-registration">WAEC Registration PIN</option>
                    <option value="neco">NECO Result Checker</option>
                    <option value="jamb">JAMB PIN VENDING</option>
                </select>
            </div>

            <div id="exam_cards_container" style="display:none">
                <label class="fl">Select Type/Package</label>
                <div class="data-grid" id="exam_cards"></div>
            </div>

            <input type="hidden" name="variation_code" id="exam_variation">
            
            <div id="exam_purchase_details" style="display:none; margin-top: 25px; padding-top: 25px; border-top: 1px solid var(--gb);">
                <div class="ftit" style="font-size: 0.9rem; color: var(--purple);">Step 2: Verify Your Details</div>
                <div class="fg"><label class="fl">Profile ID / Exam Number</label>
                    <div style="display:flex; gap:10px">
                        <input type="text" name="billersCode" id="exam_meter" class="fctl" placeholder="Enter number" required>
                        <button type="button" class="wbtn" onclick="vb('exam')">Verify</button>
                    </div>
                    <div id="exam_verify_name" style="font-size:0.75rem; margin-top:5px; color:var(--green); font-weight:700"></div>
                </div>

                <div class="ftit" style="font-size: 0.9rem; color: var(--purple); margin-top: 20px;">Step 3: Complete Your Purchase</div>
                <div class="fg" style="display:none" id="exam_amount_fg"><label class="fl">Amount (₦)</label><input type="number" name="amount" id="exam_amount" class="fctl" readonly></div>
                <div class="fg"><label class="fl">Recipient Phone Number</label><input type="tel" name="phone" class="fctl" placeholder="e.g. 08012345678" maxlength="11" required></div>

                <div class="fg"><label class="fl">Transaction PIN</label>
                    <div class="pass-container">
                        <input type="password" name="pin" class="fctl" placeholder="4-digit PIN" maxlength="4" required autocomplete="off">
                        <button type="button" class="monkey-toggle">🙈</button>
                    </div>
                </div>
                <button type="submit" class="bsub">Buy Exam Pin</button>
            </div>
        </form>
    </div>
</div>


<div class="view" id="view-transactions">
    <div class="sech"><span class="sect">Transaction History</span></div>
    <div class="txl">
        @forelse(auth()->user()->transactions()->latest()->take(20)->get() as $tx)
            <div class="txi" style="cursor:pointer" onclick="showTxDetails('{{ $tx->reference }}', '{{ $tx->type }}', '{{ number_format($tx->amount, 2) }}', '{{ $tx->status }}', '{{ $tx->created_at->format('M d, Y h:i A') }}', '{{ base64_encode($tx->details) }}')">
                <div class="txic" style="background:var(--cb)">{{ $tx->type === 'withdrawal' ? '📤' : '🛒' }}</div>
                <div class="txin">
                    <div class="txt">{{ ucfirst($tx->type) }} - {{ $tx->reference }}</div>
                    <div class="txd">{{ $tx->created_at->diffForHumans() }} • ₦{{ number_format($tx->amount, 2) }} • {{ strtoupper($tx->status) }}</div>
                </div>
            </div>
        @empty
            <div class="txi" style="justify-content:center;padding:2rem;flex-direction:column;text-align:center;gap:.5rem"><span style="font-size:2rem">📋</span><span style="font-weight:600;font-size:.9rem">No transactions yet</span></div>
        @endforelse
    </div>
</div>

<div class="view" id="view-withdraw">
    <div class="fc">
        <div class="ftit">📤 Withdraw Funds</div>
        @if(auth()->user()->is_verified)
            <form action="{{ route('account.withdraw') }}" method="POST">
                @csrf
                <div class="fg"><label class="fl">Select Bank</label>
                    <select name="bank_code" class="fctl" required>
                        <option value="044">Access Bank</option>
                        <option value="058">Guaranty Trust Bank</option>
                        <option value="033">United Bank for Africa</option>
                        <option value="011">First Bank of Nigeria</option>
                        <option value="057">Zenith Bank</option>
                        <option value="035">Wema Bank</option>
                        <option value="070">Fidelity Bank</option>
                        <option value="214">First City Monument Bank</option>
                        <option value="030">Heritage Bank</option>
                        <option value="301">Jaiz Bank</option>
                        <option value="082">Keystone Bank</option>
                        <option value="526">Parallex Bank</option>
                        <option value="076">Polaris Bank</option>
                        <option value="221">Stanbic IBTC Bank</option>
                        <option value="068">Standard Chartered Bank</option>
                        <option value="232">Sterling Bank</option>
                        <option value="100">SunTrust Bank</option>
                        <option value="032">Union Bank of Nigeria</option>
                        <option value="215">Unity Bank</option>
                        <option value="090110">VFD Microfinance Bank</option>
                        <option value="999992">OPay</option>
                        <option value="999991">Palmpay</option>
                        <option value="50515">Moniepoint MFB</option>
                        <option value="50211">Kuda Bank</option>
                    </select>
                </div>
                <div class="fg"><label class="fl">Account Number</label>
                    <input type="number" name="account_number" id="an_input" class="fctl" placeholder="10-digit number" maxlength="10" required>
                    <div id="an_lookup" style="font-size:0.75rem; margin-top:5px; color:var(--purple); font-weight:700"></div>
                </div>
                <div class="fg"><label class="fl">Amount (₦)</label><input type="number" name="amount" class="fctl" placeholder="Minimum ₦100" min="100" required></div>
                <div class="fg"><label class="fl">Transaction PIN</label>
                    <div class="pass-container">
                        <input type="password" name="pin" class="fctl" placeholder="4-digit PIN" maxlength="4" required autocomplete="off">
                        <button type="button" class="monkey-toggle">🙈</button>
                    </div>
                </div>
                <button type="submit" class="bsub">Withdraw Instantly</button>
            </form>
        @else
            <div style="text-align:center;padding:2rem">
                <span style="font-size:3rem">🔒</span>
                <h3 style="margin-top:1rem">Account Not Verified</h3>
                <p style="font-size:.8rem;color:var(--muted);margin-top:.5rem">Withdrawals are only available for verified accounts.</p>
                <button class="wbtn" style="margin-top:1.5rem" onclick="sv('profile',null)">Go to Profile</button>
            </div>
        @endif
    </div>
</div>

<div class="view" id="view-profile">
    <div class="fc"><div class="ftit">👤 My Profile</div>
        <form action="{{ route('account.profile.update') }}" method="POST">
            @csrf
            <div class="fg"><label class="fl">Full Name</label><input type="text" name="name" class="fctl" value="{{ auth()->user()->name }}"></div>
            <div class="fg"><label class="fl">Email Address</label><input type="email" class="fctl" value="{{ auth()->user()->email }}" disabled></div>
            
            <div style="margin:2rem 0; padding:1.5rem; background:rgba(255,255,255,0.03); border-radius:15px; border:1px solid var(--gb)">
                <div style="font-weight:700; margin-bottom:1rem; font-size:0.9rem; color:var(--purple)">🔐 Change Transaction PIN</div>
                <div class="fg"><label class="fl">Account Password</label>
                    <input type="password" name="current_password" class="fctl" placeholder="Enter account password">
                </div>
                <div class="fg"><label class="fl">New 4-digit PIN</label>
                    <input type="password" name="new_pin" class="fctl" placeholder="Set 4-digit PIN" maxlength="4">
                </div>
                <div class="fg"><label class="fl">Confirm New PIN</label>
                    <input type="password" name="new_pin_confirmation" class="fctl" placeholder="Confirm 4-digit PIN" maxlength="4">
                </div>
                <button type="submit" formaction="{{ route('account.request-pin-change') }}" class="wbtn" style="width:100%">Request PIN Change</button>
            </div>

            <div class="fg"><label class="fl">BVN Verification</label>
                <div style="display:flex;gap:10px">
                    <input type="text" form="bvn-form" name="bvn" class="fctl" placeholder="11-digit BVN" maxlength="11" {{ auth()->user()->bvn_verified_at ? 'disabled' : '' }} value="{{ auth()->user()->bvn }}">
                    @if(!auth()->user()->bvn_verified_at)
                        <button type="submit" form="bvn-form" class="wbtn">Verify</button>
                    @else
                        <span style="color:var(--green);font-size:.8rem;align-self:center">Verified ✓</span>
                    @endif
                </div>
            </div>

            <button type="submit" class="bsub" style="margin-top:1rem">Save Profile Details</button>
        </form>
        <form id="bvn-form" action="{{ route('account.verify-bvn') }}" method="POST" style="display:none">@csrf</form>
    </div>
</div>

<div class="view" id="view-support">
    <div class="fc">
        <div class="ftit">💬 Customer Support</div>
        <form action="{{ route('support.store') }}" method="POST">
            @csrf
            <div class="fg"><label class="fl">Subject</label><input type="text" name="subject" class="fctl" placeholder="Issue?" required></div>
            <div class="fg"><label class="fl">Message</label><textarea name="message" class="fctl" rows="4" required></textarea></div>
            <button type="submit" class="bsub">Submit Complaint</button>
        </form>
    </div>
</div>

<div class="view" id="view-subscriptions">
    <div class="sech">
        <span class="sect">🔄 Recurring Subscriptions</span>
    </div>
    
    @if(isset($subscriptions) && $subscriptions->count() > 0)
        <div class="txl">
            @foreach($subscriptions as $sub)
                <div class="txi" style="flex-wrap: wrap; gap: 15px;">
                    <div class="txic" style="background: rgba(185,28,28,0.1); color: var(--purple);">🔄</div>
                    <div class="txin">
                        <div class="txt">{{ strtoupper($sub->service_id) }} - {{ $sub->variation_code }}</div>
                        <div class="txd">
                            Next Run: {{ $sub->next_run_at ? $sub->next_run_at->format('d M Y') : 'N/A' }} | 
                            Runs: {{ $sub->current_runs }}{{ $sub->max_runs ? '/'.$sub->max_runs : '' }}
                        </div>
                    </div>
                    <div class="txa">₦{{ number_format($sub->amount, 2) }}</div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span class="txs {{ $sub->status == 'active' ? 'ss' : ($sub->status == 'cancelled' ? 'fc' : 'sp') }}">
                            {{ strtoupper($sub->status) }}
                        </span>
                        @if($sub->status == 'active')
                            <button onclick="cancelSub({{ $sub->id }}, this)" style="background: rgba(239,68,68,0.1); color: #f87171; border: 1px solid rgba(239,68,68,0.2); padding: 5px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 700; cursor: pointer; transition: all 0.3s;">Cancel</button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="text-align:center; padding: 50px 20px; background: var(--cb); border-radius: 20px; border: 1px dashed var(--gb);">
            <div style="font-size: 3rem; margin-bottom: 15px;">🔄</div>
            <div class="ftit" style="margin-bottom: 5px;">No Recurring Subscriptions</div>
            <p style="color: var(--muted); font-size: 0.85rem;">Your active auto-renewals will appear here.</p>
        </div>
    @endif
</div>

<script>
    async function cancelSub(id, btn) {
        if (!confirm('Are you sure you want to cancel this recurring payment?')) return;
        
        const oldText = btn.textContent;
        btn.textContent = 'Wait...';
        btn.disabled = true;
        
        try {
            const res = await fetch(`/purchase/subscriptions/${id}/cancel`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = await res.json();
            if (data.success) {
                location.reload(); // Refresh to update status
            } else {
                alert(data.message);
                btn.textContent = oldText;
                btn.disabled = false;
            }
        } catch (e) {
            alert('An error occurred.');
            btn.textContent = oldText;
            btn.disabled = false;
        }
    }
</script>
