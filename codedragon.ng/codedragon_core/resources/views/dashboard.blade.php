<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

    <!-- Main Dashboard View -->
    <div class="view active" id="view-dashboard">
        @if(!auth()->user()->is_verified && !auth()->user()->bvn_verified_at)
        <div class="notice">
            <div class="noti">⚠️</div>
            <div>
                <strong>Account Pending Verification</strong>
                <p>Your account is under review. Services activate once verification is complete. Email info@codedragon.ng</p>
            </div>
        </div>
        @endif

        <div class="wc">
            <div class="wr">
                <div>
                    <div class="wl" style="display: flex; align-items: center; gap: 8px;">
                        Wallet Balance 
                        <button id="refreshBalance" style="background: none; border: none; cursor: pointer; font-size: 0.9rem; color: rgba(255,255,255,0.5); display: flex; align-items: center;" title="Refresh Balance">🔄</button>
                        <button id="toggleBalance" style="background: none; border: none; cursor: pointer; font-size: 1.1rem; color: rgba(255,255,255,0.5); display: flex; align-items: center;">👁️</button>
                    </div>
                    <div class="wb"><small>₦</small><span id="balance-value">{{ number_format(auth()->user()->wallet->balance ?? 0, 2) }}</span></div>
                    <div class="wid">Account ID: CT-{{ str_pad(auth()->user()->id, 5, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div class="wa" style="position: relative; z-index: 10;">
                    <button class="wbtn" onclick="sm('fund')">+ Fund</button>
                    <button class="wbtn" onclick="sv('withdraw',this)">Withdraw</button>
                </div>
            </div>
            
            @if(auth()->user()->wallet && auth()->user()->wallet->virtual_account_number)
            <div style="margin-top:20px; padding-top:15px; border-top:1px solid rgba(255,255,255,0.1); display:flex; flex-wrap:wrap; gap:15px; align-items:center;">
                <div style="display:flex; align-items:center; gap:5px;">
                    <span style="font-size:10px; color:rgba(255,255,255,0.5); text-transform:uppercase;">Name:</span>
                    <span style="font-size:12px; font-weight:700; color:#fff;">{{ auth()->user()->wallet->virtual_account_name }}</span>
                </div>
                <div style="display:flex; align-items:center; gap:5px;">
                    <span style="font-size:10px; color:rgba(255,255,255,0.5); text-transform:uppercase;">Bank:</span>
                    <span style="font-size:12px; font-weight:700; color:#fff;">{{ auth()->user()->wallet->virtual_bank_name }}</span>
                </div>
                <div style="display:flex; align-items:center; gap:5px;">
                    <span style="font-size:10px; color:rgba(255,255,255,0.5); text-transform:uppercase;">Acc:</span>
                    <span style="font-size:12px; font-weight:900; color:var(--purple);">{{ auth()->user()->wallet->virtual_account_number }}</span>
                    <button onclick="copyToClipboard('{{ auth()->user()->wallet->virtual_account_number }}')" style="background:none; border:none; cursor:pointer; font-size:12px;">📋</button>
                </div>
            </div>
            @endif
        </div>

        <div class="qg" style="grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));">
            <div class="qi" onclick="sv('airtime',this)" style="background: linear-gradient(135deg, rgba(185,28,28,0.1), rgba(168,85,247,0.05)); border: 1px solid rgba(185,28,28,0.2);">
                <div class="qicon" style="background: rgba(185,28,28,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px;">📱</div>
                <div class="qlabel" style="font-weight: 700; font-size: 0.9rem;">Buy Airtime</div>
                <div style="font-size: 0.7rem; color: var(--muted); margin-top: 4px;">Instant Topup</div>
            </div>
            <div class="qi" onclick="sv('data',this)" style="background: linear-gradient(135deg, rgba(245,185,66,0.1), rgba(185,28,28,0.05)); border: 1px solid rgba(245,185,66,0.2);">
                <div class="qicon" style="background: rgba(245,185,66,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px;">📡</div>
                <div class="qlabel" style="font-weight: 700; font-size: 0.9rem;">Buy Data</div>
                <div style="font-size: 0.7rem; color: var(--muted); margin-top: 4px;">Gigabytes Galore</div>
            </div>
            <div class="qi" onclick="sv('electricity',this)" style="background: linear-gradient(135deg, rgba(251,191,36,0.1), rgba(185,28,28,0.05)); border: 1px solid rgba(251,191,36,0.2);">
                <div class="qicon" style="background: rgba(251,191,36,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px;">⚡</div>
                <div class="qlabel" style="font-weight: 700; font-size: 0.9rem;">Utility Bills</div>
                <div style="font-size: 0.7rem; color: var(--muted); margin-top: 4px;">Light Up Home</div>
            </div>
            <div class="qi" onclick="sv('cable',this)" style="background: linear-gradient(135deg, rgba(34,197,94,0.1), rgba(185,28,28,0.05)); border: 1px solid rgba(34,197,94,0.2);">
                <div class="qicon" style="background: rgba(34,197,94,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px;">📺</div>
                <div class="qlabel" style="font-weight: 700; font-size: 0.9rem;">TV Sub</div>
                <div style="font-size: 0.7rem; color: var(--muted); margin-top: 4px;">Cable TV</div>
            </div>
            <div class="qi" onclick="sv('exampins',this)" style="background: linear-gradient(135deg, rgba(239,68,68,0.1), rgba(185,28,28,0.05)); border: 1px solid rgba(239,68,68,0.2);">
                <div class="qicon" style="background: rgba(239,68,68,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px;">🎓</div>
                <div class="qlabel" style="font-weight: 700; font-size: 0.9rem;">Exam Pins</div>
                <div style="font-size: 0.7rem; color: var(--muted); margin-top: 4px;">WAEC/NECO/JAMB</div>
            </div>
        </div>

        @if(isset($hotDeals) && $hotDeals->isNotEmpty())
        <div class="sech" style="margin-top:20px"><span class="sect">🔥 Hot Deals</span></div>
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px, 1fr)); gap:15px; margin-bottom:20px;">
            @foreach($hotDeals as $deal)
            <div class="qi card-hot" style="background:linear-gradient(135deg, rgba(245,185,66,0.1), rgba(185,28,28,0.1)); border:1px solid rgba(245,185,66,0.3); text-align:left; padding:15px; position:relative;" onclick="openDataWithPlan('{{ $deal->service_id }}', '{{ $deal->variation_code }}')">
                <div style="font-size:12px; font-weight:800; color:white; margin-bottom:4px;">{{ $deal->name }}</div>
                <div style="font-size:18px; font-weight:900; color:var(--green);">₦{{ number_format($deal->retail_price, 2) }}</div>
                <div style="font-size:9px; color:rgba(255,255,255,0.5); margin-top:5px;">Limited time offer!</div>
            </div>
            @endforeach
        </div>
        @endif

        <div class="sech">
            <div style="display:flex; align-items:center; gap:10px;">
                <span class="sect">Recent Transactions</span>
                <span id="live-indicator" style="display:inline-flex; align-items:center; gap:4px; font-size:9px; background:rgba(34,197,94,0.1); color:#22c55e; padding:2px 6px; border-radius:10px; font-weight:700; border:1px solid rgba(34,197,94,0.2);">
                    <span style="width:5px; height:5px; background:#22c55e; border-radius:50%; animation: pulse 1.5s infinite;"></span> LIVE
                </span>
            </div>
            <a href="#" class="secl" onclick="sv('transactions',null);return false">View all</a>
        </div>
        
        @if(session('status'))
            <div style="background:rgba(34,197,94,0.1); border:1px solid #22c55e; color:#22c55e; padding:1rem; border-radius:12px; margin-bottom:1rem; font-size:.85rem; font-weight:600">
                ✅ {{ session('status') }}
            </div>
        @endif
        @if($errors->any())
            <div style="background:rgba(239,68,68,0.1); border:1px solid #ef4444; color:#ef4444; padding:1rem; border-radius:12px; margin-bottom:1rem; font-size:.85rem; font-weight:600">
                ❌ {{ $errors->first() }}
            </div>
        @endif

        <div class="txl" id="dashboard-tx-list">
            @php
                try {
                    $dashboard_tx = auth()->user()->transactions()->latest()->take(3)->get();
                } catch (\Exception $e) {
                    $dashboard_tx = collect();
                }
            @endphp
            @forelse($dashboard_tx as $tx)
            <div class="txi">
                <div class="txic">@if($tx->type == 'funding') 💰 @elseif($tx->type == 'withdrawal') 🏧 @else 🛒 @endif</div>
                <div class="txf">
                    <div class="txn">{{ ucfirst($tx->type) }} - {{ $tx->reference }}</div>
                    <div class="txd">{{ $tx->created_at->format('M d, h:i A') }}</div>
                </div>
                <div class="txa @if($tx->status == 'success') tx-plus @else tx-minus @endif">
                    {{ $tx->type == 'funding' ? '+' : '-' }}₦{{ number_format($tx->amount, 2) }}
                </div>
            </div>
            @empty
            <div class="txi" style="justify-content: center; opacity: 0.5;">No transactions yet.</div>
            @endforelse
        </div>
    </div>

    <!-- Features Views & Modals -->
    @include('dashboard.views')
    @include('dashboard.modals')

    <script>
        function sv(viewId, btn) {
            document.querySelectorAll('.view').forEach(v => v.classList.remove('active'));
            const target = document.getElementById('view-' + viewId);
            if (target) {
                target.classList.add('active');
                window.scrollTo(0,0);
                
                // Update URL parameter without reload
                const url = new URL(window.location);
                url.searchParams.set('v', viewId);
                window.history.pushState({}, '', url);
            }
            
            // Handle sidebar highlighting
            document.querySelectorAll('.ni').forEach(s => s.classList.remove('active'));
            if (btn) {
                btn.classList.add('active');
            } else {
                // Try to find the button in sidebar by viewId
                const sideBtn = document.querySelector(`.ni[onclick*="'${viewId}'"]`) || document.querySelector(`.ni[href*="v=${viewId}"]`);
                if (sideBtn) sideBtn.classList.add('active');
            }
        }
        function sm(id) {
            const modal = document.getElementById('mo-' + id);
            if (modal) {
                modal.classList.add('active');
            }
        }
        function cm(event) {
            if (event && event.target !== event.currentTarget) return;
            document.querySelectorAll('.mo').forEach(m => m.classList.remove('active'));
        }
        // Global Vars
        const authPhone = '{{ auth()->user()->phone }}';

        // Transaction Details Modal
        function showTxDetails(ref, type, amount, status, date, detailsB64) {
            let details = {};
            try {
                details = JSON.parse(atob(detailsB64));
            } catch(e) { console.error("JSON parse failed", e); }

            const token = details.mainToken || details.purchased_code || details.token || (details.content ? (details.content.token || details.content.purchased_code) : null);
            
            let modalHtml = `
                <div class="modal-overlay active" id="tx-modal-overlay" onclick="closeTxModal(event)">
                    <div class="receipt-card" id="receipt-capture-area">
                        <div style="text-align:center; margin-bottom: 25px;">
                            <div style="margin-bottom: 15px; display: flex; justify-content: center;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <div style="width:34px; height:34px; border-radius:9px; background:linear-gradient(135deg,var(--purple),var(--fuchsia)); display:flex; align-items:center; justify-content:center; font-family:'Syne',sans-serif; font-weight:800; font-size:15px; color:#fff;">C</div>
                                    <div style="font-family:'Syne',sans-serif; font-weight:700; font-size:1.05rem; letter-spacing:-.02em; color:#fff;">Candy<span style="color:var(--purple);">Tech</span></div>
                                </div>
                            </div>
                            <div class="ftit" style="margin-bottom:5px; font-size: 1.2rem;">Transaction Receipt</div>
                            <div style="font-size:0.7rem; color:var(--muted); text-transform:uppercase; letter-spacing:2px; font-weight:700;">Official Payment Confirmation</div>
                        </div>

                        <div style="display:flex; flex-direction:column; gap:12px; margin-bottom: 25px; background:rgba(255,255,255,0.02); padding:20px; border-radius:18px; border:1px solid var(--gb);">
                            <div style="display:flex; justify-content:space-between; font-size: 0.8rem;">
                                <span style="color:var(--muted)">Reference</span>
                                <span style="font-weight:700; color:#fff;">${ref}</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size: 0.8rem;">
                                <span style="color:var(--muted)">Service</span>
                                <span style="font-weight:700; color:#fff;">${type.toUpperCase()}</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size: 0.8rem;">
                                <span style="color:var(--muted)">Amount</span>
                                <span style="font-weight:700; color:var(--green);">₦${amount}</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size: 0.8rem;">
                                <span style="color:var(--muted)">Status</span>
                                <span style="font-weight:700; color:var(--green); text-transform:uppercase;">● ${status}</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size: 0.8rem;">
                                <span style="color:var(--muted)">Date</span>
                                <span style="font-weight:700; color:#fff;">${date}</span>
                            </div>
                        </div>

                        ${token ? `
                            <div class="token-box" style="margin-bottom: 25px; border-style: solid; border-width: 1px; background:rgba(185,28,28,0.1);">
                                <div class="token-label">TOKEN / PIN</div>
                                <div class="token-value" style="font-size:1.4rem;">${token}</div>
                                <button type="button" class="token-copy" onclick="copyToken('${token}', this)">📋 Copy Code</button>
                            </div>
                        ` : ''}

                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px; margin-bottom:15px;" id="receipt-actions">
                            <button class="wbtn" onclick="downloadReceipt('${ref}')" style="background:rgba(59,130,246,0.2); border-color:rgba(59,130,246,0.3);">🖼️ Save Image</button>
                            <button class="wbtn" onclick="printReceipt()" style="background:rgba(34,197,94,0.2); border-color:rgba(34,197,94,0.3);">📄 Save PDF</button>
                        </div>
                        
                        <button class="bsub" onclick="closeTxModal(null)" style="height: 50px; background:var(--gb); border:1px solid var(--gb);">Close Receipt</button>
                        
                        <div style="text-align:center; margin-top:20px; font-size:10px; color:var(--muted); opacity:0.5;">
                            Thank you for using CodeDragon!
                        </div>
                    </div>
                </div>
            `;
            
            const div = document.createElement('div');
            div.id = 'tx-modal-container';
            div.innerHTML = modalHtml;
            document.body.appendChild(div);
        }

        function downloadReceipt(ref) {
            const area = document.getElementById('receipt-capture-area');
            const actions = document.getElementById('receipt-actions');
            actions.style.display = 'none'; // Hide buttons during capture
            
            html2canvas(area, {
                backgroundColor: '#05020a',
                scale: 2, // High quality
                borderRadius: 28
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = `CodeDragon-Receipt-${ref}.png`;
                link.href = canvas.toDataURL('image/png');
                link.click();
                actions.style.display = 'grid'; // Show buttons again
            });
        }

        function printReceipt() {
            window.print();
        }

        function closeTxModal(e) {
            if (e && e.target !== e.currentTarget) return;
            const modal = document.getElementById('tx-modal-container');
            if (modal) modal.remove();
        }

        function copyToken(val, btn) {
            navigator.clipboard.writeText(val).then(() => {
                const oldText = btn.textContent;
                btn.textContent = '✅ Copied!';
                btn.style.background = 'var(--green)';
                setTimeout(() => {
                    btn.textContent = oldText;
                    btn.style.background = '';
                }, 2000);
            });
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Copied to clipboard!');
            });
        }
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const view = urlParams.get('v');
            if (view) {
                const targetView = document.getElementById('view-' + view);
                if (targetView) {
                    sv(view, null);
                }
            }

            const toggleBalanceBtn = document.getElementById('toggleBalance');
            const balanceEl = document.getElementById('balance-value');
            if (toggleBalanceBtn && balanceEl) {
                let hidden = localStorage.getItem('balance_hidden') === 'true';
                const updateUI = () => {
                    if (hidden) {
                        balanceEl.textContent = '****.**';
                        toggleBalanceBtn.textContent = '👁️';
                    } else {
                        balanceEl.textContent = '{{ number_format(auth()->user()->wallet->balance ?? 0, 2) }}';
                        toggleBalanceBtn.textContent = '🙈';
                    }
                };
                updateUI();
                toggleBalanceBtn.addEventListener('click', () => {
                    hidden = !hidden;
                    localStorage.setItem('balance_hidden', hidden);
                    updateUI();
                });
            }
        });

        // Feature Specific Scripts
        let allDataPlans = [];
        function ld(sid, autoSelectCode = null, context = 'data') {
            // Hide purchase details when provider changes
            const details = document.getElementById(context + '_purchase_details');
            if (details) details.style.display = 'none';

            if (!sid) {
                if (context === 'data') {
                    document.getElementById('data_tabs').style.display = 'none';
                    document.getElementById('data_cards').innerHTML = '';
                } else {
                    document.getElementById(context + '_cards_container').style.display = 'none';
                    document.getElementById(context + '_cards').innerHTML = '';
                }
                return;
            }
            fetchVariations(sid, autoSelectCode, context);
        }

        async function fetchVariations(sid, autoSelectCode = null, context = 'data') {
            const grid = document.getElementById(context === 'data' ? 'data_cards' : context + '_cards');
            const tabs = document.getElementById('data_tabs');
            const container = document.getElementById(context + '_cards_container');
            
            grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 2rem;">Loading premium plans...</div>';
            if (container) container.style.display = 'block';

            try {
                const r = await fetch('/purchase/variations/' + sid);
                const variations = await r.json();
                
                if (context === 'data') {
                    allDataPlans = variations;
                    tabs.style.display = 'flex';
                    filterData('hot');
                    
                    if (autoSelectCode) {
                        const plan = allDataPlans.find(p => p.variation_code === autoSelectCode);
                        if (plan) {
                            filterData(plan.category || 'others');
                            setTimeout(() => {
                                const card = Array.from(document.querySelectorAll('.data-card')).find(c => c.innerHTML.includes(plan.name));
                                if (card) selectPlan(plan, card);
                            }, 100);
                        }
                    }
                } else {
                    grid.innerHTML = '';
                    variations.forEach(v => {
                        const price = parseFloat(v.retail_price) || parseFloat(v.wholesale_price) || 0;
                        const card = document.createElement('div');
                        card.className = 'data-card';
                        card.innerHTML = `
                            <div class="d-name">${v.name}</div>
                            <div class="d-price">${price > 0 ? '₦' + price.toLocaleString() : 'Variable'}</div>
                        `;
                        card.onclick = () => {
                            document.querySelectorAll('#' + context + '_cards .data-card').forEach(c => c.classList.remove('selected'));
                            card.classList.add('selected');
                            document.getElementById(context + '_variation').value = v.variation_code;
                            
                            // Show purchase details
                            const details = document.getElementById(context + '_purchase_details');
                            if (details) details.style.display = 'block';

                            if (context === 'cable' || context === 'exam') {
                                document.getElementById(context + '_amount').value = price;
                                if (context === 'exam') {
                                    document.getElementById('exam_amount_fg').style.display = 'block';
                                }
                            }
                        };
                        grid.appendChild(card);
                    });
                }
            } catch (e) {
                grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; color: var(--red);">Failed to load plans.</div>';
            }
        }

        function sa(sid, cardEl) {
            document.querySelectorAll('#view-airtime .data-card').forEach(c => c.classList.remove('selected'));
            cardEl.classList.add('selected');
            document.getElementById('airtime_service').value = sid;
            document.getElementById('airtime_purchase_details').style.display = 'block';
        }

        function attachFormListener(form) {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const context = form.getAttribute('data-context');
                const notify = document.getElementById(context + '_notification') || form.querySelector('.purchase-notification');
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                
                // Show Global Loader
                document.getElementById('global-loader').style.display = 'flex';
                if (notify) notify.style.display = 'none';
                submitBtn.disabled = true;

                try {
                    const formData = new FormData(form);
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });

                    const result = await response.json();
                    
                    if (result.success) {
                        // If in modal, close it
                        const modal = document.getElementById('tx-modal-container');
                        if (modal) modal.remove();
                        
                        // Show Success Receipt
                        showTxDetails(result.reference, result.type, result.amount, 'SUCCESS', 'Just now', btoa(JSON.stringify(result.data)));
                        
                        form.reset();
                        
                        // Update wallet balance in UI
                        if (result.new_balance) {
                            const balEl = document.getElementById('balance-value');
                            if (balEl) balEl.textContent = result.new_balance;
                            document.querySelectorAll('.wallet-balance-option').forEach(opt => {
                                opt.textContent = 'Wallet (₦' + result.new_balance + ')';
                            });
                        }
                    } else {
                        if (notify) {
                            notify.textContent = result.message;
                            notify.className = 'purchase-notification error';
                            notify.style.display = 'block';
                        } else {
                            alert(result.message);
                        }
                    }
                } catch (error) {
                    if (notify) {
                        notify.textContent = '❌ An error occurred. Please try again.';
                        notify.className = 'purchase-notification error';
                        notify.style.display = 'block';
                    }
                } finally {
                    document.getElementById('global-loader').style.display = 'none';
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            });
        }

        // AJAX Form Submission - Initial Attachment
        document.querySelectorAll('.purchase-form').forEach(form => attachFormListener(form));

        async function vb(context) {
            const sid = document.querySelector(`#view-${context === 'elec' ? 'electricity' : context === 'exam' ? 'exampins' : context} select[name="serviceID"]`).value;
            const bcode = document.getElementById(context + '_meter').value;
            const resEl = document.getElementById(context + '_verify_name');
            const type = (context === 'exam') ? document.getElementById('exam_variation').value : null;
            
            if (!sid || !bcode) { alert('Select provider and enter number'); return; }
            if (context === 'exam' && !type) { alert('Select exam type first'); return; }
            
            resEl.textContent = 'Verifying...';
            try {
                const r = await fetch('{{ route('purchase.validate-biller') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ serviceID: sid, billersCode: bcode, type: type })
                });
                const d = await r.json();
                if (d.success) {
                    resEl.innerHTML = `
                        <div style="background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.2); padding:15px; border-radius:12px; margin-top:10px;">
                            <div style="color:var(--green); font-weight:800; font-size:0.9rem; margin-bottom:5px;">✅ Verified: ${d.name}</div>
                            <button type="button" class="bsub" style="height:40px; font-size:0.8rem;" onclick="openBillerModal('${context}', '${sid}', '${bcode}', '${d.name}', '${type || ''}')">Proceed to Payment</button>
                        </div>
                    `;
                } else {
                    resEl.textContent = '❌ ' + d.message;
                    resEl.style.color = 'var(--red)';
                }
            } catch (e) {
                resEl.textContent = '❌ Verification failed';
            }
        }

        function openBillerModal(context, sid, bcode, name, type) {
            const isElec = (context === 'elec');
            const isExam = (context === 'exam');
            
            let modalHtml = `
                <div class="modal-overlay active" onclick="closeTxModal(event)">
                    <div class="receipt-card" style="max-width: 450px;">
                        <div style="text-align:center; margin-bottom: 25px;">
                            <div style="width:50px; height:50px; background:rgba(185,28,28,0.2); border-radius:15px; display:flex; align-items:center; justify-content:center; margin:0 auto 15px; font-size:1.5rem;">${isElec ? '⚡' : isExam ? '🎓' : '📺'}</div>
                            <div class="ftit" style="margin-bottom:5px;">Complete Payment</div>
                            <div style="font-size:0.8rem; color:var(--purple); font-weight:700;">${name}</div>
                        </div>

                        <form action="{{ route('purchase.buy') }}" method="POST" class="purchase-form" data-context="${context}">
                            @csrf
                            <input type="hidden" name="serviceID" value="${sid}">
                            <input type="hidden" name="billersCode" value="${bcode}">
                            <input type="hidden" name="variation_code" value="${isExam ? type : (isElec ? document.getElementById('elec_variation').value : document.getElementById('cable_variation').value)}">

                            <div class="fg"><label class="fl">Amount (₦)</label>
                                <input type="number" name="amount" class="fctl" placeholder="${isElec ? 'Min 500' : '0.00'}" required ${isElec ? 'min="500"' : ''}>
                            </div>

                            <div class="fg"><label class="fl">Phone Number</label>
                                <input type="tel" name="phone" class="fctl" placeholder="08012345678" maxlength="11" required value="${authPhone}">
                            </div>

                            <div style="display:flex; align-items:center; gap:10px; margin: 15px 0; padding: 15px; background: rgba(185,28,28,0.1); border-radius: 12px; border: 1px solid rgba(185,28,28,0.2);">
                                <input type="checkbox" name="recurring" value="on" id="modal_recurring_toggle" onchange="toggleModalRecurring()" style="width: 22px; height: 22px; accent-color: var(--purple);">
                                <label for="modal_recurring_toggle" style="margin: 0; font-size: 0.9rem; font-weight: 700; cursor: pointer;">Setup Recurring Payment</label>
                            </div>

                            <div id="modal_recurring_fields" style="display:none; margin-bottom: 20px; padding: 15px; border: 1px dashed var(--gb); border-radius: 12px;">
                                <div class="fg"><label class="fl">Interval (Every X Days)</label><input type="number" name="frequency_days" class="fctl" value="30" min="1"></div>
                                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                    <div class="fg"><label class="fl">Total Runs (Optional)</label><input type="number" name="max_runs" class="fctl" placeholder="e.g. 5"></div>
                                    <div class="fg"><label class="fl">End Date (Optional)</label><input type="date" name="end_at" class="fctl"></div>
                                </div>
                            </div>

                            <div class="fg"><label class="fl">Transaction PIN</label>
                                <input type="password" name="pin" class="fctl" placeholder="4-digit PIN" maxlength="4" required>
                            </div>

                            <div id="${context}_notification" class="purchase-notification" style="display:none; margin-bottom: 15px;"></div>

                            <button type="submit" class="bsub" style="height: 55px;">Pay Now</button>
                            <button type="button" class="wbtn" onclick="closeTxModal(null)" style="width:100%; margin-top:10px; height:45px; background:transparent; border:none; color:var(--muted);">Cancel</button>
                        </form>
                    </div>
                </div>
            `;
            
            const div = document.createElement('div');
            div.id = 'tx-modal-container';
            div.innerHTML = modalHtml;
            document.body.appendChild(div);

            // Re-attach form listener for the new modal form
            attachFormListener(div.querySelector('.purchase-form'));
        }

        function filterData(cat) {
            // Update tabs UI
            document.querySelectorAll('#data_tabs .tab').forEach(t => {
                t.classList.toggle('active', t.textContent.toLowerCase().includes(cat));
            });

            const grid = document.getElementById('data_cards');
            grid.innerHTML = '';

            let filtered = [];
            if (cat === 'hot') {
                filtered = allDataPlans.filter(p => p.is_hot_deal);
            } else {
                filtered = allDataPlans.filter(p => {
                    const pCat = p.category ? p.category.toLowerCase() : 'others';
                    if (pCat === cat) return true;
                    
                    const name = p.name.toLowerCase();
                    if (cat === 'daily') return name.includes('24 hrs') || name.includes('1 day') || name.includes('daily');
                    if (cat === 'weekly') return name.includes('7 days') || name.includes('week');
                    if (cat === 'monthly') return name.includes('30 days') || name.includes('month');
                    return false;
                });
            }

            if (filtered.length === 0) {
                grid.innerHTML = `<div style="grid-column: 1/-1; text-align: center; padding: 2rem; opacity: 0.5;">No ${cat} plans available for this network.</div>`;
                return;
            }

            filtered.forEach(p => {
                const price = parseFloat(p.retail_price) || parseFloat(p.wholesale_price) || 0;
                const card = document.createElement('div');
                card.className = `data-card ${p.is_hot_deal ? 'card-hot' : ''}`;
                const badgeText = p.is_hot_deal ? 'Hot Deal' : (p.category ? p.category : 'Data');
                card.innerHTML = `
                    <div class="d-badge">${badgeText}</div>
                    <div class="d-name">${p.name}</div>
                    <div class="d-price">₦${price.toLocaleString()}</div>
                    <div class="d-freq">${p.is_hot_deal ? 'Limited Offer 🔥' : 'Auto-renew available'}</div>
                `;
                card.onclick = () => selectPlan(p, card);
                grid.appendChild(card);
            });
        }

        function selectPlan(p, cardEl) {
            document.querySelectorAll('.data-card').forEach(c => c.classList.remove('selected'));
            cardEl.classList.add('selected');
            
            const price = parseFloat(p.retail_price) || parseFloat(p.wholesale_price) || 0;
            const context = 'data';
            
            // Set frequency
            const name = p.name.toLowerCase();
            let freqDays = 30;
            if (name.includes('day') || name.includes('24 hrs') || name.includes('daily')) freqDays = 1;
            else if (name.includes('week') || name.includes('7 days')) freqDays = 7;

            // Open Purchase Modal
            let modalHtml = `
                <div class="modal-overlay active" onclick="closeTxModal(event)">
                    <div class="receipt-card" style="max-width: 450px;">
                        <div style="text-align:center; margin-bottom: 25px;">
                            <div style="width:50px; height:50px; background:rgba(185,28,28,0.2); border-radius:15px; display:flex; align-items:center; justify-content:center; margin:0 auto 15px; font-size:1.5rem;">🛍️</div>
                            <div class="ftit" style="margin-bottom:5px;">Complete Purchase</div>
                            <div style="font-size:0.8rem; color:var(--purple); font-weight:700;">${p.name}</div>
                        </div>

                        <form action="{{ route('purchase.buy') }}" method="POST" class="purchase-form" data-context="${context}">
                            @csrf
                            <input type="hidden" name="serviceID" value="${document.querySelector('select[name="serviceID"]').value}">
                            <input type="hidden" name="variation_code" value="${p.variation_code}">
                            <input type="hidden" name="amount" value="${price}">

                            <div class="fg"><label class="fl">Phone Number</label>
                                <input type="tel" name="phone" class="fctl" placeholder="08012345678" maxlength="11" required value="${document.getElementById('data_phone').value}">
                            </div>

                            <div style="display:flex; align-items:center; gap:10px; margin: 15px 0; padding: 15px; background: rgba(185,28,28,0.1); border-radius: 12px; border: 1px solid rgba(185,28,28,0.2);">
                                <input type="checkbox" name="recurring" value="on" id="modal_recurring_toggle" onchange="toggleModalRecurring()" style="width: 22px; height: 22px; accent-color: var(--purple);">
                                <label for="modal_recurring_toggle" style="margin: 0; font-size: 0.9rem; font-weight: 700; cursor: pointer;">Setup Recurring Payment</label>
                            </div>

                            <div id="modal_recurring_fields" style="display:none; margin-bottom: 20px; padding: 15px; border: 1px dashed var(--gb); border-radius: 12px;">
                                <div class="fg"><label class="fl">Interval (Every X Days)</label><input type="number" name="frequency_days" class="fctl" value="${freqDays}" min="1"></div>
                                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                    <div class="fg"><label class="fl">Total Runs (Optional)</label><input type="number" name="max_runs" class="fctl" placeholder="e.g. 5"></div>
                                    <div class="fg"><label class="fl">End Date (Optional)</label><input type="date" name="end_at" class="fctl"></div>
                                </div>
                            </div>

                            <div class="fg"><label class="fl">Payment Method</label>
                                <select name="payment_method" class="fctl">
                                    <option value="wallet">Wallet (₦${document.getElementById('balance-value').textContent})</option>
                                    <option value="direct">Direct Bank Transfer</option>
                                </select>
                            </div>

                            <div class="fg"><label class="fl">Transaction PIN</label>
                                <input type="password" name="pin" class="fctl" placeholder="4-digit PIN" maxlength="4" required>
                            </div>

                            <div id="${context}_notification" class="purchase-notification" style="display:none; margin-bottom: 15px;"></div>

                            <button type="submit" class="bsub" style="height: 55px;">Pay ₦${price.toLocaleString()}</button>
                            <button type="button" class="wbtn" onclick="closeTxModal(null)" style="width:100%; margin-top:10px; height:45px; background:transparent; border:none; color:var(--muted);">Cancel</button>
                        </form>
                    </div>
                </div>
            `;
            
            const div = document.createElement('div');
            div.id = 'tx-modal-container';
            div.innerHTML = modalHtml;
            document.body.appendChild(div);

            // Re-attach form listener for the new modal form
            attachFormListener(div.querySelector('.purchase-form'));
        }

        function toggleModalRecurring() {
            const toggle = document.getElementById('modal_recurring_toggle');
            const fields = document.getElementById('modal_recurring_fields');
            if (toggle && fields) fields.style.display = toggle.checked ? 'block' : 'none';
        }

        function openDataWithPlan(sid, vcode) {
            sv('data', null);
            const select = document.querySelector('select[name="serviceID"]');
            if (select) {
                select.value = sid;
                ld(sid, vcode);
            }
        }

        // Auto-refresh balance and transactions
        async function updateDashboard() {
            try {
                // Update Balance
                const balRes = await fetch('{{ route('account.balance') }}');
                const balData = await balRes.json();
                const balEl = document.getElementById('balance-value');
                if (balEl && balData.balance && localStorage.getItem('balance_hidden') !== 'true') {
                    balEl.textContent = balData.balance;
                }

                // Update Transactions
                const txRes = await fetch('{{ route('account.transactions') }}');
                const txData = await txRes.json();
                const txList = document.getElementById('dashboard-tx-list');
                if (txList && txData.length > 0) {
                    txList.innerHTML = txData.slice(0, 3).map(tx => `
                        <div class="txi">
                            <div class="txic">${tx.icon}</div>
                            <div class="txf">
                                <div class="txn">${tx.type} - ${tx.reference}</div>
                                <div class="txd">${tx.date}</div>
                            </div>
                            <div class="txa ${tx.status == 'success' ? 'tx-plus' : 'tx-minus'}">
                                ${tx.type == 'Funding' ? '+' : '-'}₦${tx.amount}
                            </div>
                        </div>
                    `).join('');
                }
            } catch (e) {
                console.error('Dashboard update failed', e);
            }
        }

        const refreshBtn = document.getElementById('refreshBalance');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', function() {
                this.style.transform = 'rotate(360deg)';
                this.style.transition = 'transform 0.5s';
                updateDashboard();
                setTimeout(() => { this.style.transform = 'rotate(0deg)'; this.style.transition = 'none'; }, 500);
            });
        }

        // Pulse animation for LIVE indicator
        const style = document.createElement('style');
        style.innerHTML = '@keyframes pulse { 0% { opacity: 0.4; } 50% { opacity: 1; } 100% { opacity: 0.4; } }';
        document.head.appendChild(style);
    </script>
    <!-- Global Loader Overlay -->
    <div id="global-loader">
        <div class="loader-logo">C</div>
        <div class="loader-spinner"></div>
        <div class="loader-text">PROCESSING...</div>
    </div>

    <script>
        function toggleRecurringDetails(context) {
            const toggle = document.getElementById(context + '_recurring_toggle');
            const fields = document.getElementById(context + '_recurring_fields');
            if (toggle && fields) {
                fields.style.display = toggle.checked ? 'block' : 'none';
            }
        }
    </script>
</x-app-layout>
