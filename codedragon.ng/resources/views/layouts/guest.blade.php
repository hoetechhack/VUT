<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CodeDragon') }}</title>
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">

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
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 1rem;
            }
            .auth-card {
                width: 100%;
                max-width: 450px;
                background: var(--glass);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid var(--glass-border);
                border-radius: 24px;
                padding: 2.5rem;
                box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            }
            .fctl {
                width: 100%;
                background: rgba(15, 10, 30, 0.8);
                border: 2px solid var(--glass-border);
                border-radius: 12px;
                padding: 1rem 1.25rem;
                color: var(--text);
                font-family: 'Inter', sans-serif;
                font-size: 1rem;
                outline: none;
                transition: border-color .2s, box-shadow .2s;
                font-weight: 600;
                margin-top: 8px;
            }
            .fctl:focus {
                border-color: var(--purple);
                box-shadow: 0 0 15px rgba(185, 28, 28, 0.35);
            }
            .fl {
                font-size: .8rem;
                font-weight: 700;
                color: var(--muted);
                text-transform: uppercase;
                letter-spacing: .05em;
                display: block;
            }
            .bsub {
                width: 100%;
                background: linear-gradient(135deg, var(--purple), var(--fuchsia));
                color: #fff;
                border: none;
                border-radius: 12px;
                padding: 1rem;
                font-size: 1rem;
                font-weight: 800;
                cursor: pointer;
                transition: opacity .2s, transform .15s;
                text-transform: uppercase;
                letter-spacing: 1px;
                margin-top: 1.5rem;
            }
            .bsub:hover { opacity: .9; transform: translateY(-1px); }
            .google-btn {
                background: #fff;
                color: #000;
                border-radius: 12px;
                padding: 1rem;
                font-weight: 800;
                font-size: 0.95rem;
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 12px;
                text-decoration: none;
                transition: transform 0.2s;
                margin-top: 1rem;
            }
            .google-btn:hover { transform: translateY(-1px); background: #f8f8f8; }
        </style>
    </head>
    <body>
        <div class="auth-card">
            <div style="text-align: center; margin-bottom: 2.5rem;">
                <a href="/" style="display: inline-block;">
                    <x-logo height="60" />
                </a>
            </div>

            {{ $slot }}
        </div>
    </body>
</html>
