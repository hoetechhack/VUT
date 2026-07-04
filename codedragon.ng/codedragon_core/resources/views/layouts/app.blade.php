<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CodeDragon') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <style>
            :root {
                --bg: #0a0505;
                --bg-alt: #150a0a;
                --purple: #B91C1C;
                --purple-bright: #E11D2E;
                --fuchsia: #F5B942;
                --text: #FFFFFF;
                --muted: #d7c9c9;
                --glass: rgba(20, 10, 10, 0.7);
                --glass-border: rgba(255, 255, 255, 0.12);
            }
            body {
                background: radial-gradient(circle at 20% 30%, rgba(185, 28, 28, 0.25), transparent 40%),
                            radial-gradient(circle at 80% 70%, rgba(245, 185, 66, 0.12), transparent 40%),
                            var(--bg);
                background-image: radial-gradient(rgba(185, 28, 28, 0.15) 1px, transparent 1px);
                background-size: 40px 40px;
                color: var(--text);
                font-family: 'Inter', sans-serif;
                font-weight: 500;
                min-height: 100vh;
            }
            .traditional-input {
                background: rgba(20, 10, 10, 0.9) !important;
                border: 2px solid rgba(255, 255, 255, 0.15) !important;
                border-radius: 4px !important;
                padding: 0.9rem 1.1rem !important;
                font-size: 1rem !important;
                color: #fff !important;
                width: 100%;
                transition: all 0.3s ease;
                font-weight: 700 !important;
            }
            .traditional-input:focus {
                border-color: #B91C1C !important;
                box-shadow: 0 0 20px rgba(185, 28, 28, 0.4) !important;
                outline: none;
            }
            .pass-container { position: relative; width: 100%; }
            .monkey-toggle {
                position: absolute; right: 15px; top: 50%; transform: translateY(-50%);
                background: none; border: none; font-size: 1.5rem; cursor: pointer;
                z-index: 10;
            }

            /* Floating Blobs */
            .orb-field { position: fixed; inset: 0; z-index: -1; pointer-events: none; overflow: hidden; }
            .blob {
                position: absolute; width: 600px; height: 600px;
                background: radial-gradient(circle, rgba(185, 28, 28, 0.18), transparent 70%);
                filter: blur(120px); animation: floatBlob 15s ease-in-out infinite;
            }
            .blob-2 { top: 40%; right: -100px; background: radial-gradient(circle, rgba(245, 185, 66, 0.1), transparent 70%); animation-delay: -5s; }
            @keyframes floatBlob {
                0%, 100% { transform: translate(0, 0) scale(1); }
                50% { transform: translate(60px, -40px) scale(1.1); }
            }

            /* High Definition Content */
            .bg-white { background: var(--glass) !important; backdrop-filter: blur(15px); border: 1px solid var(--glass-border) !important; }
            .text-gray-900, .text-gray-800, .text-gray-700 { color: #fff !important; font-weight: 800 !important; }
            .text-gray-600, .text-gray-500 { color: #d7c9c9 !important; font-weight: 600 !important; }
            .bg-gray-50 { background: rgba(255,255,255,0.03) !important; border: 1px solid var(--glass-border) !important; }

            /* Sharp Tables */
            table { width: 100%; border-collapse: separate; border-spacing: 0; }
            th { background: rgba(185, 28, 28, 0.12) !important; color: #fff !important; font-weight: 900 !important; text-transform: uppercase; letter-spacing: 1px; padding: 1.25rem 1rem !important; border-bottom: 2px solid var(--purple) !important; text-align: left; }
            td { padding: 1.25rem 1rem !important; color: #fff !important; font-weight: 600 !important; border-bottom: 1px solid rgba(255,255,255,0.05) !important; }
            tr:hover td { background: rgba(255,255,255,0.02); }

            label { font-weight: 800 !important; color: #fff !important; text-transform: uppercase; letter-spacing: 0.5px; font-size: 0.85rem !important; margin-bottom: 8px; display: block; }
        </style>
        <!-- Custom UI Styles -->
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    </head>
    <body class="font-sans antialiased">
        <div class="orb-field">
            <div class="blob"></div>
            <div class="blob blob-2"></div>
        </div>

        <div class="app">
            @include('layouts.navbar', ['title' => $header ?? 'Dashboard'])

            <main class="mc">
                @if(isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </main>
        </div>

        <script>
            function toggleDrawer() {
                const dw = document.getElementById('drawer');
                const ov = document.getElementById('drawerOverlay');
                dw.classList.toggle('open');
                ov.classList.toggle('show');
            }

            document.addEventListener('DOMContentLoaded', () => {
                // Initialize password toggles if not already handled
                document.querySelectorAll('.monkey-toggle').forEach(btn => {
                    if (btn.dataset.init) return;
                    btn.dataset.init = "true";
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        const input = btn.previousElementSibling;
                        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                        input.setAttribute('type', type);
                        btn.textContent = type === 'password' ? '🙈' : '🐵';
                    });
                });

                // Apply traditional-input class to all relevant inputs on non-dashboard pages
                @if(!request()->routeIs('dashboard'))
                    document.querySelectorAll('input:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([type="button"]), select, textarea').forEach(el => {
                        el.classList.add('fctl'); // Use 'fctl' from dashboard.css for consistency
                    });
                @endif
            });
        </script>
    </body>
</html>
