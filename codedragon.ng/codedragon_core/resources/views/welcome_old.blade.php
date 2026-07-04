<!-- Developed by Hoetech Technical Support — contact: hoetech.tsc@gmail.com -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CandyTech – Fast, Secure Bill Payments in Nigeria</title>
<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
<meta name="description" content="Top up airtime, buy data, pay electricity bills, cable TV, and get exam pins instantly. CandyTech delivers fast digital transactions at the best rates.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --bg: #08080F;
    --bg2: #101018;
    --bg3: #12121A;
    --purple: #7C4DFF;
    --purple-bright: #9B70FF;
    --purple-light: #B899FF;
    --fuchsia: #D946EF;
    --green: #00E676;
    --text: #F1EEF9;
    --muted: rgba(255, 255, 255, 0.5);
    --card-bg: rgba(255, 255, 255, 0.03);
    --card-border: rgba(255, 255, 255, 0.07);
    --glass: rgba(255, 255, 255, 0.03);
    --glass-border: rgba(255, 255, 255, 0.07);
  }

  html, body { overflow-x: hidden; width: 100%; scroll-behavior: smooth; }

  body {
    background: var(--bg);
    color: var(--text);
    font-family: 'Inter', sans-serif;
    font-size: 15px;
    line-height: 1.7;
    overflow-x: hidden;
  }

  h1, h2, h3, h4, .logo-text, .btn-primary, .btn-outline { font-family: 'Inter', sans-serif; }

  /* ─── ORBS ─────────────────────────────── */
  .orb-field {
    position: fixed; inset: 0; z-index: 0; pointer-events: none; overflow: hidden;
  }
  .orb {
    position: absolute; border-radius: 50%; filter: blur(80px); opacity: 0.25;
  }
  .orb-1 {
    width: 500px; height: 500px;
    background: radial-gradient(circle, #7C3AED, transparent 70%);
    top: -150px; left: -150px;
    animation: drift1 18s ease-in-out infinite alternate;
  }
  .orb-2 {
    width: 400px; height: 400px;
    background: radial-gradient(circle, #D946EF, transparent 70%);
    top: 30%; right: -100px;
    animation: drift2 22s ease-in-out infinite alternate;
  }
  .orb-3 {
    width: 350px; height: 350px;
    background: radial-gradient(circle, #4F46E5, transparent 70%);
    bottom: 10%; left: 10%;
    animation: drift3 15s ease-in-out infinite alternate;
  }
  @keyframes drift1 { to { transform: translate(80px, 100px); } }
  @keyframes drift2 { to { transform: translate(-60px, 80px); } }
  @keyframes drift3 { to { transform: translate(40px, -60px); } }

  /* ─── NAV ──────────────────────────────── */
  nav {
    position: fixed; top: 0; left: 0; right: 0; z-index: 100;
    padding: 0 1.25rem;
    background: rgba(8, 8, 15, 0.95);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--glass-border);
    height: 64px;
    display: flex; align-items: center; justify-content: space-between;
  }
  .logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
  .logo-icon {
    width: 36px; height: 36px; border-radius: 10px;
    background: linear-gradient(135deg, var(--purple), var(--fuchsia));
    display: flex; align-items: center; justify-content: center;
    font-family: 'Syne', sans-serif; font-weight: 800; font-size: 16px; color: #fff;
    flex-shrink: 0;
  }
  .logo-text { font-weight: 700; font-size: 1.15rem; color: var(--text); letter-spacing: -0.02em; }
  .logo-text span { color: var(--purple-light); }

  .nav-links { display: flex; align-items: center; gap: 1.5rem; }
  .nav-links a {
    color: var(--muted); text-decoration: none; font-size: 0.875rem;
    font-weight: 500; transition: color 0.2s;
  }
  .nav-links a:hover { color: var(--text); }
  @media (max-width: 640px) { .nav-links .hide-mobile { display: none; } }

  .btn-primary {
    display: inline-flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, var(--purple), var(--purple-bright));
    color: #fff; text-decoration: none; font-weight: 600; font-size: 0.875rem;
    padding: 0.5rem 1.25rem; border-radius: 10px; border: none; cursor: pointer;
    transition: opacity 0.2s, transform 0.15s;
    font-family: 'Plus Jakarta Sans', sans-serif;
    white-space: nowrap;
  }
  .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
  .btn-primary:active { transform: scale(0.97); }

  .btn-outline {
    display: inline-flex; align-items: center; justify-content: center;
    background: transparent;
    color: var(--text); text-decoration: none; font-weight: 600; font-size: 0.875rem;
    padding: 0.65rem 1.5rem; border-radius: 10px;
    border: 1.5px solid var(--card-border); cursor: pointer;
    transition: border-color 0.2s, background 0.2s, transform 0.15s;
    font-family: 'Plus Jakarta Sans', sans-serif;
    white-space: nowrap;
  }
  .btn-outline:hover { border-color: var(--purple-bright); background: var(--card-bg); transform: translateY(-1px); }

  /* ─── HERO ─────────────────────────────── */
  .hero {
    position: relative; z-index: 1;
    min-height: 100vh;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    text-align: center;
    padding: 100px 1.5rem 60px;
  }
  .hero::before {
    content: ''; position: absolute; top: 35%; left: 50%; transform: translate(-50%, -50%);
    width: 600px; height: 600px; border-radius: 50%;
    background: radial-gradient(circle, rgba(124,77,255,0.18), transparent 70%);
    pointer-events: none; z-index: -1;
  }

  .hero-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(124, 77, 255, 0.15);
    border: 1px solid rgba(124, 77, 255, 0.3);
    padding: 6px 14px; border-radius: 100px;
    font-size: 0.78rem; font-weight: 600; color: var(--purple-light);
    letter-spacing: 0.04em; text-transform: uppercase;
    margin-bottom: 1.75rem;
    opacity: 0; animation: fadeUp 0.6s 0.1s ease forwards;
  }
  .hero-badge .dot {
    width: 7px; height: 7px; background: var(--green);
    border-radius: 50%; animation: pulse 2s infinite;
  }
  @keyframes pulse { 0%,100% { opacity:1; transform:scale(1); } 50% { opacity:0.5; transform:scale(1.3); } }

  .hero h1 {
    font-size: clamp(2.4rem, 8vw, 52px);
    font-weight: 900;
    line-height: 1.05;
    letter-spacing: -2px;
    max-width: 800px;
    opacity: 0; animation: fadeUp 0.7s 0.25s ease forwards;
  }
  .hero h1 .accent-purple { color: var(--purple); }
  .hero h1 .accent-green { color: var(--green); }

  .hero-sub {
    font-size: clamp(1rem, 3vw, 1.2rem);
    color: var(--muted);
    max-width: 520px;
    margin: 1.25rem auto 0;
    line-height: 1.65;
    opacity: 0; animation: fadeUp 0.7s 0.4s ease forwards;
  }

  .hero-ctas {
    display: flex; flex-wrap: wrap; gap: 0.875rem;
    justify-content: center; margin-top: 2.25rem;
    opacity: 0; animation: fadeUp 0.7s 0.55s ease forwards;
  }
  .hero-ctas .btn-primary { padding: 0.85rem 2rem; font-size: 1rem; border-radius: 12px; }
  .hero-ctas .btn-outline { padding: 0.85rem 2rem; font-size: 1rem; border-radius: 12px; }

  .hero-trust {
    display: flex; align-items: center; gap: 0.75rem;
    margin-top: 2rem; font-size: 0.8rem; color: var(--muted);
    opacity: 0; animation: fadeUp 0.7s 0.7s ease forwards;
    flex-wrap: wrap; justify-content: center;
  }
  .trust-item { display: flex; align-items: center; gap: 5px; }
  .trust-item svg { width: 14px; height: 14px; fill: #22c55e; flex-shrink: 0; }
  .trust-sep { color: var(--glass-border); }

  /* HERO CARD */
  .hero-card {
    margin-top: 3.5rem;
    background: var(--glass);
    border: 1px solid rgba(124, 77, 255, 0.3);
    box-shadow: 0 0 30px rgba(124, 77, 255, 0.1);
    border-radius: 20px;
    padding: 1.5rem;
    max-width: 420px; width: 100%;
    opacity: 0; animation: fadeUp 0.8s 0.85s ease forwards, float 6s ease-in-out infinite;
    position: relative; overflow: hidden;
  }
  @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
  .hero-card::before {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(124,77,255,0.08) 0%, transparent 60%);
    pointer-events: none;
  }
  .wallet-label { font-size: 0.78rem; color: var(--muted); font-weight: 500; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 4px; }
  .wallet-balance { font-family: 'Syne', sans-serif; font-size: 2.2rem; font-weight: 800; color: var(--text); }
  .wallet-balance span { font-size: 1.1rem; color: var(--muted); font-weight: 400; }
  .wallet-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.25rem; }
  .wallet-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; }
  .wallet-action {
    background: rgba(124,58,237,0.12); border: 1px solid rgba(124,58,237,0.15);
    border-radius: 12px; padding: 0.75rem; text-align: center;
    cursor: pointer; transition: background 0.2s;
  }
  .wallet-action:hover { background: rgba(124,58,237,0.2); }
  .wallet-action .icon { font-size: 1.4rem; margin-bottom: 4px; }
  .wallet-action .label { font-size: 0.78rem; font-weight: 600; color: var(--muted); }
  .wallet-chip {
    display: inline-flex; align-items: center; gap: 5px; font-size: 0.72rem;
    background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.2);
    color: #4ade80; padding: 3px 10px; border-radius: 100px; font-weight: 600;
  }
  .chip-dot { width: 5px; height: 5px; background: #4ade80; border-radius: 50%; }

  @keyframes fadeUp {
    from { opacity:0; transform: translateY(20px); }
    to { opacity:1; transform: translateY(0); }
  }

  /* ─── STATS ────────────────────────────── */
  .stats-bar {
    position: relative; z-index: 1;
    background: var(--bg2);
    border-top: 1px solid var(--glass-border);
    border-bottom: 1px solid var(--glass-border);
    padding: 1.5rem 1.25rem;
  }
  .stats-inner {
    max-width: 900px; margin: 0 auto;
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;
    text-align: center;
  }
  .stat-value { font-family: 'Syne', sans-serif; font-size: 1.75rem; font-weight: 800; color: var(--text); }
  .stat-label { font-size: 0.78rem; color: var(--muted); font-weight: 500; margin-top: 2px; }
  @media (max-width: 400px) { .stat-value { font-size: 1.4rem; } }

  /* ─── SECTION COMMON ───────────────────── */
  section { position: relative; z-index: 1; }
  .section-inner { max-width: 1000px; margin: 0 auto; padding: 56px 1.5rem; }
  .section-tag {
    display: inline-block; font-size: 0.72rem; font-weight: 700;
    color: var(--purple-light); letter-spacing: 0.1em; text-transform: uppercase;
    margin-bottom: 0.75rem;
  }
  .section-title {
    font-size: clamp(1.75rem, 5vw, 34px);
    font-weight: 800; line-height: 1.1; letter-spacing: -0.025em;
    margin-bottom: 36px;
  }
  .section-sub { font-size: 1rem; color: var(--muted); max-width: 520px; line-height: 1.7; }

  /* ─── SERVICES ─────────────────────────── */
  .services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: 1rem;
  }
  .service-card {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px; padding: 1.5rem 1rem;
    text-align: center; cursor: pointer;
    transition: transform 0.25s, border-color 0.25s, background 0.25s;
    text-decoration: none; color: inherit;
    display: block;
  }
  .service-card:hover {
    transform: translateY(-2px);
    border-color: rgba(124,77,255,0.4);
    background: rgba(255,255,255,0.05);
  }
  .service-card:hover .svc-icon { background: rgba(124,77,255,0.3); }
  .svc-icon {
    width: 52px; height: 52px; border-radius: 14px; margin: 0 auto 0.875rem;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.6rem;
    background: var(--glass);
    border: 1px solid var(--glass-border);
    transition: background 0.25s;
  }
  .svc-name { font-family: 'Inter', sans-serif; font-weight: 700; font-size: 0.92rem; color: var(--text); margin-bottom: 4px; }
  .svc-desc { font-size: 0.76rem; color: var(--muted); line-height: 1.5; }

  /* ─── HOW IT WORKS ─────────────────────── */
  .hiw-bg { background: var(--bg2); }
  .steps { display: flex; flex-direction: column; gap: 1rem; position: relative; }
  .tracking-line, .tracking-dot { display: none; }

  @media (min-width: 640px) { 
    .steps { flex-direction: row; } 
    .tracking-line {
      display: block; position: absolute; background: rgba(124,77,255,0.2);
      top: 55px; left: 16%; right: 16%; height: 2px; width: auto; bottom: auto; transform: none; z-index: 0;
    }
    .tracking-dot {
      display: flex; justify-content: center; align-items: center;
      position: absolute; width: 30px; height: 30px; border-radius: 50%;
      background: var(--bg2); border: 1px solid rgba(124,77,255,0.4); box-shadow: 0 0 15px rgba(124,77,255,0.3);
      z-index: 1; top: 41px; left: 16%; transform: none; font-size: 16px;
      animation: trackHorizontal 8s infinite cubic-bezier(0.4, 0, 0.2, 1);
    }
    @keyframes trackHorizontal {
      0% { left: 16%; opacity: 0; }
      5% { opacity: 1; }
      30%, 40% { left: 50%; }
      65%, 75% { left: 83%; }
      95% { opacity: 1; }
      100% { left: 83%; opacity: 0; }
    }
  }
  .step {
    flex: 1; background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px; padding: 2rem 1.5rem;
    position: relative; z-index: 1; text-align: center;
  }
  .step-num {
    width: 32px; height: 32px; border-radius: 50%;
    background: var(--purple); color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem; font-weight: 800; margin: 0 auto 1.25rem;
    transition: all 0.3s ease;
  }
  .step:nth-child(3) .step-num { animation: blinkStep1 8s infinite; }
  .step:nth-child(4) .step-num { animation: blinkStep2 8s infinite; }
  .step:nth-child(5) .step-num { animation: blinkStep3 8s infinite; }

  @keyframes blinkStep1 {
    5%, 20% { box-shadow: 0 0 15px var(--fuchsia), 0 0 30px var(--purple); background: var(--fuchsia); transform: scale(1.15); }
  }
  @keyframes blinkStep2 {
    30%, 50% { box-shadow: 0 0 15px var(--fuchsia), 0 0 30px var(--purple); background: var(--fuchsia); transform: scale(1.15); }
  }
  @keyframes blinkStep3 {
    65%, 85% { box-shadow: 0 0 15px var(--fuchsia), 0 0 30px var(--purple); background: var(--fuchsia); transform: scale(1.15); }
  }
  .step h3 { font-size: 1.05rem; font-weight: 700; margin-bottom: 0.5rem; }
  .step p { font-size: 0.85rem; color: var(--muted); line-height: 1.6; }

  /* ─── ABOUT ────────────────────────────── */
  .about-grid {
    display: grid; grid-template-columns: 1fr;
    gap: 2.5rem; margin-top: 2.5rem; align-items: center;
  }
  @media (min-width: 720px) { .about-grid { grid-template-columns: 1fr 1fr; } }
  .about-text p { color: var(--muted); font-size: 0.95rem; margin-bottom: 1rem; line-height: 1.8; }
  .about-perks { display: flex; flex-direction: column; gap: 0.875rem; }
  .perk {
    display: flex; align-items: flex-start; gap: 0.875rem;
    background: var(--card-bg); border: 1px solid var(--card-border);
    border-radius: 14px; padding: 1rem 1.1rem;
    transition: transform 0.2s, border-color 0.2s;
  }
  .perk:hover { transform: translateX(4px); border-color: rgba(124,58,237,0.4); }
  .perk-icon {
    width: 40px; height: 40px; border-radius: 10px;
    background: rgba(124,58,237,0.15);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; flex-shrink: 0;
  }
  .perk-title { font-weight: 700; font-size: 0.9rem; margin-bottom: 2px; }
  .perk-desc { font-size: 0.78rem; color: var(--muted); }

  /* ─── CTA BAND ─────────────────────────── */
  .cta-band {
    background: linear-gradient(135deg, rgba(124,77,255,0.2), rgba(0,230,118,0.08));
    border-top: 1px solid rgba(124,77,255,0.3);
    border-bottom: 1px solid rgba(124,77,255,0.3);
    position: relative; overflow: hidden;
  }
  .cta-band-inner {
    max-width: 1000px; margin: 0 auto;
    padding: 4rem 1.5rem;
    display: flex; flex-direction: column; align-items: center; text-align: center; gap: 2rem;
  }
  @media (min-width: 768px) {
    .cta-band-inner { flex-direction: row; justify-content: space-between; text-align: left; }
  }
  .cta-glow {
    position: absolute; width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(124,77,255,0.2), transparent 70%);
    top: 50%; left: 50%; transform: translate(-50%,-50%);
    border-radius: 50%; pointer-events: none;
  }
  .cta-band-content h2 {
    font-size: clamp(1.7rem, 5vw, 2.4rem);
    font-weight: 800; letter-spacing: -0.025em;
    margin-bottom: 0.5rem; line-height: 1.15;
  }
  .cta-band-content p { color: rgba(255,255,255,0.7); font-size: 0.95rem; }
  .cta-band .btn-primary { padding: 1rem 2.5rem; font-size: 1rem; border-radius: 14px; flex-shrink: 0; }

  /* ─── FOOTER ───────────────────────────── */
  footer {
    position: relative; z-index: 1;
    background: var(--bg);
    border-top: 1px solid var(--glass-border);
    padding: 3rem 1.5rem 2rem;
  }
  .footer-inner { max-width: 1000px; margin: 0 auto; }
  .footer-top {
    display: grid; grid-template-columns: 1fr;
    gap: 2rem; margin-bottom: 2.5rem;
  }
  @media (min-width: 640px) { .footer-top { grid-template-columns: 1.5fr 1fr 1fr; } }
  .footer-brand .logo { margin-bottom: 0.75rem; }
  .footer-brand p { font-size: 0.83rem; color: var(--muted); line-height: 1.7; margin-bottom: 0.5rem; }
  .footer-col h4 { font-family: 'Syne', sans-serif; font-size: 0.83rem; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase; margin-bottom: 1rem; color: var(--muted); }
  .footer-col a { display: block; font-size: 0.85rem; color: var(--muted); text-decoration: none; margin-bottom: 0.5rem; transition: color 0.2s; }
  .footer-col a:hover { color: var(--text); }
  .footer-bottom {
    border-top: 1px solid var(--glass-border);
    padding-top: 1.5rem;
    display: flex; flex-direction: column; gap: 0.5rem; align-items: flex-start;
  }
  @media (min-width: 640px) { .footer-bottom { flex-direction: row; justify-content: space-between; align-items: center; } }
  .footer-bottom p { font-size: 0.78rem; color: var(--muted); }
  .footer-bottom a { color: var(--muted); text-decoration: none; }
  .footer-bottom a:hover { color: var(--purple-light); }
  .dev-credit { font-size: 0.72rem; color: rgba(154,143,181,0.5); }
  .dev-credit a { color: rgba(154,143,181,0.5); }
  .dev-credit a:hover { color: var(--muted); }

  /* ─── REVEAL ───────────────────────────── */
  .reveal {
    opacity: 0; transform: translateY(40px) scale(0.95);
    transition: opacity 0.8s cubic-bezier(0.2, 0.8, 0.2, 1), transform 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
  }
  .reveal.visible { opacity: 1; transform: translateY(0) scale(1); }

  /* ─── WAVE BACKGROUND ──────────────────── */
  .wave-bg {
    position: fixed; bottom: 0; left: 0; width: 100%; height: auto; z-index: 0; pointer-events: none; overflow: hidden;
  }
  .wave-svg {
    width: 200%; height: auto; transform: translateY(20%);
    animation: waveDrift 20s infinite linear; display: block;
  }
  @keyframes waveDrift {
    0% { transform: translateX(0) translateY(20%); }
    50% { transform: translateX(-25%) translateY(25%); }
    100% { transform: translateX(0) translateY(20%); }
  }

</style>
</head>
<body>

<!-- Floating orbs background -->
<div class="orb-field">
  <div class="orb orb-1"></div>
  <div class="orb orb-2"></div>
  <div class="orb orb-3"></div>
</div>

<!-- Animated Background Wave -->
<div class="wave-bg">
  <svg class="wave-svg" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
    <path fill="url(#wave-grad)" fill-opacity="0.1" d="M0,160L48,170.7C96,181,192,203,288,202.7C384,203,480,181,576,144C672,107,768,53,864,64C960,75,1056,149,1152,176C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    <defs>
      <linearGradient id="wave-grad" x1="0%" y1="0%" x2="100%" y2="0%">
        <stop offset="0%" stop-color="#7C4DFF" />
        <stop offset="100%" stop-color="#00E676" />
      </linearGradient>
    </defs>
  </svg>
</div>

<!-- ─────────── NAV ─────────── -->
<nav>
  <a href="/" class="logo">
    <img src="{{ asset('images/logo.svg') }}" alt="CandyTech Logo" style="height: 36px; width: auto;">
  </a>
  <div class="nav-links">
    <a href="#services" class="hide-mobile">Services</a>
    <a href="#about" class="hide-mobile">About</a>
    <a href="/login" class="hide-mobile" style="color: var(--muted);">Login</a>
    <a href="/register" class="btn-primary">Get Started</a>
  </div>
</nav>

<!-- ─────────── HERO ─────────── -->
<section class="hero">
  <div class="hero-badge">
    <span class="dot"></span>
    Nigeria's Fastest VTU Platform
  </div>

  <h1>
    Pay Bills.<br>
    <span class="accent-purple">Stay Connected.</span><br>
    <span class="accent-green">Save More.</span>
  </h1>

  <p class="hero-sub">
    Top up airtime, buy data, pay electricity bills, renew cable TV, and get exam pins — all in seconds, right from your phone.
  </p>

  <div class="hero-ctas">
    <a href="/register" class="btn-primary">Create Free Account</a>
    <a href="#services" class="btn-outline">Explore Services</a>
  </div>

  <div class="hero-trust">
    <span class="trust-item">
      <svg viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"/></svg>
      Instant Delivery
    </span>
    <span class="trust-sep">·</span>
    <span class="trust-item">
      <svg viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"/></svg>
      Secure Payments
    </span>
    <span class="trust-sep">·</span>
    <span class="trust-item">
      <svg viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"/></svg>
      Best Rates
    </span>
  </div>

  <!-- Hero wallet card -->
  <div class="hero-card">
    <div class="wallet-row">
      <div>
        <div class="wallet-label">Wallet Balance</div>
        <div class="wallet-balance"><span>₦</span>12,500<span>.00</span></div>
      </div>
      <div class="wallet-chip"><span class="chip-dot"></span> Active</div>
    </div>
    <div class="wallet-actions">
      <div class="wallet-action">
        <div class="icon">📱</div>
        <div class="label">Buy Airtime</div>
      </div>
      <div class="wallet-action">
        <div class="icon">📡</div>
        <div class="label">Buy Data</div>
      </div>
      <div class="wallet-action">
        <div class="icon">⚡</div>
        <div class="label">Electricity</div>
      </div>
      <div class="wallet-action">
        <div class="icon">📺</div>
        <div class="label">Cable TV</div>
      </div>
    </div>
  </div>
</section>

<!-- ─────────── STATS ─────────── -->
<div class="stats-bar">
  <div class="stats-inner">
    <div>
      <div class="stat-value reveal" data-count="50000">0+</div>
      <div class="stat-label">Transactions Processed</div>
    </div>
    <div>
      <div class="stat-value reveal" data-count="10000">0+</div>
      <div class="stat-label">Happy Customers</div>
    </div>
    <div>
      <div class="stat-value" style="color: #4ade80;">99.9%</div>
      <div class="stat-label">Uptime Guarantee</div>
    </div>
  </div>
</div>

<!-- ─────────── SERVICES ─────────── -->
<section id="services">
  <div class="section-inner">
    <div class="reveal">
      <div class="section-tag">What We Offer</div>
      <h2 class="section-title">Everything You Need,<br>One Platform</h2>
      <p class="section-sub">From your morning data subscription to monthly electricity token — CandyTech handles it all at the best prices in Nigeria.</p>
    </div>

    <div class="services-grid">
      <a href="{{ route('register') }}" class="service-card reveal">
        <div class="svc-icon">📱</div>
        <div class="svc-name">Buy Airtime</div>
        <div class="svc-desc">MTN, Airtel, Glo & 9mobile. Instant delivery.</div>
      </a>
      <a href="{{ route('register') }}" class="service-card reveal">
        <div class="svc-icon">📡</div>
        <div class="svc-name">Data Bundles</div>
        <div class="svc-desc">All networks. Cheapest SME & corporate data.</div>
      </a>
      <a href="{{ route('register') }}" class="service-card reveal">
        <div class="svc-icon">⚡</div>
        <div class="svc-name">Electricity</div>
        <div class="svc-desc">All DISCOs — EEDC, EKEDC, IKEDC & more.</div>
      </a>
      <a href="{{ route('register') }}" class="service-card reveal">
        <div class="svc-icon">📺</div>
        <div class="svc-name">Cable TV</div>
        <div class="svc-desc">DStv, GOtv & Startimes renewals, all bouquets.</div>
      </a>
      <a href="{{ route('register') }}" class="service-card reveal">
        <div class="svc-icon">🎓</div>
        <div class="svc-name">Exam Pins</div>
        <div class="svc-desc">WAEC, NECO & JAMB pins. Delivered instantly.</div>
      </a>
    </div>
  </div>
</section>

<!-- ─────────── HOW IT WORKS ─────────── -->
<section class="hiw-bg" id="how-it-works">
  <div class="section-inner">
    <div class="reveal">
      <div class="section-tag">Simple Process</div>
      <h2 class="section-title">Up & Running in 3 Steps</h2>
      <p class="section-sub">No complicated forms. No long waits. Just fast, easy transactions from your phone.</p>
    </div>
    <div class="steps">
      <div class="tracking-line"></div>
      <div class="tracking-dot">🚗</div>
      <div class="step reveal">
        <div class="step-num">01</div>
        <h3>Create Your Account</h3>
        <p>Sign up free in under 60 seconds. No document upload required to get started.</p>
      </div>
      <div class="step reveal">
        <div class="step-num">02</div>
        <h3>Fund Your Wallet</h3>
        <p>Deposit via your unique virtual bank account powered by Monnify. Reflects instantly.</p>
      </div>
      <div class="step reveal">
        <div class="step-num">03</div>
        <h3>Buy & Pay Instantly</h3>
        <p>Choose a service, enter the details, confirm. Your token or subscription is delivered in seconds.</p>
      </div>
    </div>
  </div>
</section>

<!-- ─────────── ABOUT ─────────── -->
<section id="about">
  <div class="section-inner">
    <div class="reveal">
      <div class="section-tag">Who We Are</div>
      <h2 class="section-title">Built for Everyday Nigerians</h2>
    </div>
    <div class="about-grid">
      <div class="about-text reveal">
        <p>CandyTech is your ultimate platform for fast, secure, and reliable bill payments. Easily top up your airtime, internet data, renew your cable TV, and pay electricity subscriptions — all from one dashboard.</p>
        <p>We provide all our utility services at the most affordable rates, helping you stay connected while keeping costs low. Designed with ease of use in mind, CandyTech delivers a highly secure and efficient service that makes everyday digital transactions a breeze.</p>
        <p style="font-size: 0.82rem; color: var(--muted); margin-top: 1.5rem;">
          📍 150 Agbani Road, Enugu South, Enugu State<br>
          📧 support@candytech.ng
        </p>
      </div>
      <div class="about-perks">
        <div class="perk reveal">
          <div class="perk-icon">⚡</div>
          <div>
            <div class="perk-title">Lightning Fast</div>
            <div class="perk-desc">Transactions complete in under 5 seconds. No delays, no waiting.</div>
          </div>
        </div>
        <div class="perk reveal">
          <div class="perk-icon">🔒</div>
          <div>
            <div class="perk-title">Bank-Grade Security</div>
            <div class="perk-desc">Your funds and data are protected with enterprise-level encryption.</div>
          </div>
        </div>
        <div class="perk reveal">
          <div class="perk-icon">💰</div>
          <div>
            <div class="perk-title">Lowest Rates</div>
            <div class="perk-desc">We pass on wholesale pricing directly to you. Always competitive.</div>
          </div>
        </div>
        <div class="perk reveal">
          <div class="perk-icon">🛎️</div>
          <div>
            <div class="perk-title">24/7 Support</div>
            <div class="perk-desc">Our support team is always available to resolve any issue fast.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ─────────── CTA BAND ─────────── -->
<section class="cta-band">
  <div class="cta-glow"></div>
  <div class="cta-band-inner">
    <div class="cta-band-content reveal">
      <h2>Ready to Get Started?</h2>
      <p>Join thousands of Nigerians already saving time and money with CandyTech. It takes less than a minute.</p>
    </div>
    <a href="/register" class="btn-primary reveal">Create Free Account</a>
  </div>
</section>

<!-- ─────────── FOOTER ─────────── -->
<footer>
  <div class="footer-inner">
    <div class="footer-top">
      <div class="footer-brand">
        <a href="/" class="logo">
          <img src="{{ asset('images/logo.svg') }}" alt="CandyTech Logo" style="height: 36px; width: auto;">
        </a>
        <p>Fast, secure, and affordable bill payments for every Nigerian. Powered by trusted aggregators and Monnify payment infrastructure.</p>
        <p>📍 150 Agbani Road, Enugu South, Enugu State</p>
      </div>
      <div class="footer-col">
        <h4>Services</h4>
        <a href="{{ route('register') }}">Buy Airtime</a>
        <a href="{{ route('register') }}">Data Bundles</a>
        <a href="{{ route('register') }}">Electricity Bills</a>
        <a href="{{ route('register') }}">Cable TV</a>
        <a href="{{ route('register') }}">Exam Pins</a>
      </div>
      <div class="footer-col">
        <h4>Legal & Support</h4>
        <a href="/privacy-policy">Privacy Policy</a>
        <a href="/terms">Terms & Conditions</a>
        <a href="/refund-policy">Refund Policy</a>
        <a href="/contact">Contact Us</a>
        <a href="mailto:support@candytech.ng">support@candytech.ng</a>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© 2025 CandyTech. All rights reserved. | <a href="/privacy-policy">Privacy</a> · <a href="/terms">Terms</a> · <a href="/refund-policy">Refund Policy</a></p>
      <p class="dev-credit">Developed by <a href="mailto:hoetech.tsc@gmail.com">Hoetech Technical Support — contact: hoetech.tsc@gmail.com</a></p>
    </div>
  </div>
</footer>

<script>
  // Stats counter animation
  const animateCountUp = (el) => {
    const target = parseInt(el.getAttribute('data-count'), 10);
    if (isNaN(target)) return;
    let startTimestamp = null;
    const duration = 2000;
    const step = (timestamp) => {
      if (!startTimestamp) startTimestamp = timestamp;
      const progress = Math.min((timestamp - startTimestamp) / duration, 1);
      const easeProgress = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
      el.innerText = Math.floor(easeProgress * target).toLocaleString() + '+';
      if (progress < 1) {
        window.requestAnimationFrame(step);
      }
    };
    window.requestAnimationFrame(step);
  };

  // Scroll reveal (Continuous)
  const reveals = document.querySelectorAll('.reveal');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((e) => {
      if (e.isIntersecting) {
        if (!e.target.classList.contains('visible')) {
          const delay = e.target.closest('.services-grid, .steps, .about-perks')
            ? Array.from(e.target.parentElement.children).indexOf(e.target) * 80
            : 0;
          setTimeout(() => {
            e.target.classList.add('visible');
            if (e.target.hasAttribute('data-count')) animateCountUp(e.target);
          }, delay);
        }
      } else {
        // Hide when scrolling away to enable continuous revealing
        e.target.classList.remove('visible');
        if (e.target.hasAttribute('data-count')) e.target.innerText = '0+';
      }
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
  reveals.forEach(el => observer.observe(el));

  // Smooth nav highlight
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const target = document.querySelector(a.getAttribute('href'));
      if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth' }); }
    });
  });
</script>
</body>
</html>
