<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CodeDragon – Fast, Secure Bill Payments in Nigeria</title>
<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
<meta name="description" content="Top up airtime, buy data, pay electricity bills, cable TV, and get exam pins instantly. CodeDragon delivers fast digital transactions at the best rates.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --bg: #0a0505;
    --bg2: #150a0a;
    --purple: #B91C1C;
    --purple-bright: #E11D2E;
    --gold: #F5B942;
    --text: #FFFFFF;
    --muted: #d7c9c9;
    --glass: rgba(20, 10, 10, 0.7);
    --glass-border: rgba(255, 255, 255, 0.12);
    --card-bg: rgba(25, 12, 12, 0.55);
    --card-border: rgba(255, 255, 255, 0.12);
    --green: #22c55e;
  }

  html, body { overflow-x: hidden; width: 100%; scroll-behavior: smooth; }

  body {
    background: radial-gradient(circle at 20% 20%, rgba(185, 28, 28, 0.15), transparent 45%),
                radial-gradient(circle at 80% 60%, rgba(245, 185, 66, 0.08), transparent 45%),
                var(--bg);
    color: var(--text);
    font-family: 'Inter', sans-serif;
    font-size: clamp(16px, 1.1vw, 20px);
    line-height: 1.6;
    font-weight: 500;
  }

  /* ─── NAV ──────────────────────────────── */
  nav {
    position: fixed; top: 0; left: 0; right: 0; z-index: 100;
    padding: 0 1.5rem; height: 76px;
    background: var(--glass); backdrop-filter: blur(15px); -webkit-backdrop-filter: blur(15px);
    border-bottom: 1px solid var(--glass-border);
    display: flex; align-items: center; justify-content: space-between;
    gap: 10px;
  }
  .nav-links { display: flex; align-items: center; gap: 1.5rem; }
  .nav-links a {
    color: var(--muted); text-decoration: none; font-size: 0.875rem;
    font-weight: 600; transition: color 0.2s;
  }
  .nav-links a:hover { color: var(--text); }
  @media (max-width: 640px) {
    .nav-links { gap: 0.75rem; }
    .nav-links .hide-mobile { display: none; }
    .nav-links .btn-primary { padding: 0.6rem 1rem; font-size: 0.8rem; }
  }

  .btn-primary {
    display: inline-flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, var(--purple), var(--purple-bright));
    color: #fff; text-decoration: none; font-weight: 700; font-size: 1rem;
    padding: 0.8rem 1.8rem; border-radius: 12px; border: none; cursor: pointer;
    box-shadow: 0 10px 30px rgba(185, 28, 28, 0.3);
    transition: transform 0.2s, box-shadow 0.2s;
    white-space: nowrap;
  }
  .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 15px 35px rgba(185, 28, 28, 0.45); }

  .btn-outline {
    display: inline-flex; align-items: center; justify-content: center;
    background: transparent;
    color: var(--text); text-decoration: none; font-weight: 600; font-size: 0.875rem;
    padding: 0.65rem 1.5rem; border-radius: 10px;
    border: 1.5px solid var(--card-border); cursor: pointer;
    transition: border-color 0.2s, background 0.2s;
    white-space: nowrap;
  }
  .btn-outline:hover { border-color: var(--purple-bright); background: var(--card-bg); }

  /* ─── HERO ─────────────────────────────── */
  .hero {
    position: relative; z-index: 1;
    padding: 150px 1.5rem 70px;
    display: flex; flex-direction: column; align-items: center; text-align: center;
  }

  .hero-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(185, 28, 28, 0.15);
    border: 1px solid rgba(185, 28, 28, 0.35);
    padding: 8px 20px; border-radius: 100px;
    font-size: 0.85rem; font-weight: 700; color: #fff;
    letter-spacing: 0.03em; text-transform: uppercase;
    margin-bottom: 1.5rem;
  }
  .hero-badge .dot { width: 7px; height: 7px; background: var(--green); border-radius: 50%; }

  .hero h1 {
    font-size: clamp(2.2rem, 6vw, 60px);
    font-weight: 900;
    line-height: 1.1;
    letter-spacing: -1.5px;
    max-width: 780px;
    color: var(--text);
  }
  .hero h1 span { color: var(--gold); }

  .hero-sub {
    font-size: clamp(1rem, 2vw, 1.15rem);
    color: var(--muted);
    max-width: 540px;
    margin: 1.25rem auto 0;
  }

  .hero-ctas {
    display: flex; flex-wrap: wrap; gap: 0.875rem;
    justify-content: center; margin-top: 2rem;
  }
  .hero-ctas .btn-primary, .hero-ctas .btn-outline { padding: 1rem 2.2rem; font-size: 1.05rem; border-radius: 14px; }

  .hero-trust {
    display: flex; align-items: center; gap: 1.25rem;
    margin-top: 2.5rem; font-size: 0.95rem; font-weight: 700; color: #fff;
    flex-wrap: wrap; justify-content: center;
  }
  .trust-item { display: flex; align-items: center; gap: 5px; }
  .trust-item svg { width: 14px; height: 14px; fill: var(--green); flex-shrink: 0; }
  .trust-sep { color: var(--glass-border); }

  /* Boxed hero video */
  .hero-video-card {
    margin-top: 3rem;
    background: var(--card-bg);
    border: 1px solid var(--glass-border);
    box-shadow: 0 20px 50px rgba(0,0,0,0.45);
    border-radius: 20px;
    padding: 10px;
    max-width: 640px; width: 100%;
  }
  .hero-video-card video {
    display: block; width: 100%; border-radius: 14px; background: #000;
  }

  /* ─── STATS ────────────────────────────── */
  .stats-bar {
    position: relative; z-index: 1;
    background: var(--bg2);
    border-top: 1px solid var(--glass-border);
    border-bottom: 1px solid var(--glass-border);
    padding: 2rem 1.25rem;
  }
  .stats-inner {
    max-width: 1000px; margin: 0 auto;
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;
    text-align: center;
  }
  @media (max-width: 768px) { .stats-inner { grid-template-columns: 1fr; gap: 2rem; } }
  .stat-value { font-size: clamp(2.2rem, 4vw, 3rem); font-weight: 900; color: var(--text); letter-spacing: -1px; }
  .stat-label { font-size: 0.95rem; color: var(--muted); font-weight: 700; margin-top: 6px; text-transform: uppercase; letter-spacing: 0.5px; }

  /* ─── SECTION COMMON ───────────────────── */
  section { position: relative; z-index: 1; }
  .section-inner { max-width: 1000px; margin: 0 auto; padding: 56px 1.5rem; }
  .section-tag {
    display: inline-block; font-size: 0.72rem; font-weight: 700;
    color: var(--gold); letter-spacing: 0.1em; text-transform: uppercase;
    margin-bottom: 0.75rem;
  }
  .section-title {
    font-size: clamp(1.6rem, 4vw, 2.1rem);
    font-weight: 800; line-height: 1.15; letter-spacing: -0.02em;
    margin-bottom: 30px;
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
    border: 1px solid var(--glass-border);
    border-radius: 18px; padding: 2rem 1.25rem;
    text-align: center; cursor: pointer;
    transition: border-color 0.2s, transform 0.2s;
    text-decoration: none; color: inherit;
  }
  .service-card:hover { transform: translateY(-4px); border-color: var(--purple); }
  .service-card.featured { border: 2px solid var(--purple); }
  .svc-icon {
    width: 56px; height: 56px; border-radius: 16px; margin: 0 auto 1.1rem;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.8rem; background: rgba(255,255,255,0.05);
    border: 1px solid var(--glass-border);
  }
  .svc-name { font-weight: 800; font-size: 1.1rem; color: #fff; margin-bottom: 6px; }
  .svc-desc { font-size: 0.85rem; color: var(--muted); line-height: 1.5; font-weight: 400; }

  /* ─── HOW IT WORKS ─────────────────────── */
  .hiw-bg { background: var(--bg2); }
  .steps { display: flex; flex-direction: column; gap: 1rem; }
  @media (min-width: 640px) { .steps { flex-direction: row; } }
  .step {
    flex: 1; background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px; padding: 1.75rem 1.5rem;
    text-align: center;
  }
  .step-num {
    width: 32px; height: 32px; border-radius: 50%;
    background: var(--purple); color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem; font-weight: 800; margin: 0 auto 1.1rem;
  }
  .step h3 { font-size: 1.02rem; font-weight: 700; margin-bottom: 0.5rem; }
  .step p { font-size: 0.85rem; color: var(--muted); line-height: 1.6; }

  /* ─── ABOUT ────────────────────────────── */
  .about-grid { display: grid; grid-template-columns: 1fr; gap: 2.5rem; margin-top: 2rem; align-items: center; }
  @media (min-width: 720px) { .about-grid { grid-template-columns: 1fr 1fr; } }
  .about-text p { color: var(--muted); font-size: 0.95rem; margin-bottom: 1rem; line-height: 1.75; }
  .about-perks { display: flex; flex-direction: column; gap: 0.75rem; }
  .perk {
    display: flex; align-items: flex-start; gap: 0.875rem;
    background: var(--card-bg); border: 1px solid var(--card-border);
    border-radius: 14px; padding: 1rem 1.1rem;
  }
  .perk-icon {
    width: 38px; height: 38px; border-radius: 10px;
    background: rgba(185,28,28,0.15);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; flex-shrink: 0;
  }
  .perk-title { font-weight: 700; font-size: 0.9rem; margin-bottom: 2px; }
  .perk-desc { font-size: 0.78rem; color: var(--muted); }

  /* ─── CTA BAND ─────────────────────────── */
  .cta-band {
    background: linear-gradient(135deg, rgba(185,28,28,0.18), rgba(245,185,66,0.06));
    border-top: 1px solid rgba(185,28,28,0.25);
    border-bottom: 1px solid rgba(185,28,28,0.25);
  }
  .cta-band-inner {
    max-width: 1000px; margin: 0 auto;
    padding: 3.5rem 1.5rem;
    display: flex; flex-direction: column; align-items: center; text-align: center; gap: 1.75rem;
  }
  @media (min-width: 768px) { .cta-band-inner { flex-direction: row; justify-content: space-between; text-align: left; } }
  .cta-band-content h2 { font-size: clamp(1.5rem, 4vw, 2.1rem); font-weight: 800; letter-spacing: -0.02em; margin-bottom: 0.5rem; }
  .cta-band-content p { color: rgba(255,255,255,0.7); font-size: 0.95rem; }

  /* ─── FOOTER ───────────────────────────── */
  footer {
    background: var(--bg);
    border-top: 1px solid var(--glass-border);
    padding: 3rem 1.5rem 2rem;
  }
  .footer-inner { max-width: 1000px; margin: 0 auto; }
  .footer-top { display: grid; grid-template-columns: 1fr; gap: 2rem; margin-bottom: 2.5rem; }
  @media (min-width: 640px) { .footer-top { grid-template-columns: 1.5fr 1fr 1fr; } }
  .footer-brand p { font-size: 0.83rem; color: var(--muted); line-height: 1.7; margin-bottom: 0.5rem; margin-top: 0.75rem; }
  .footer-col h4 { font-size: 0.8rem; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase; margin-bottom: 1rem; color: var(--muted); }
  .footer-col a { display: block; font-size: 0.85rem; color: var(--muted); text-decoration: none; margin-bottom: 0.5rem; }
  .footer-col a:hover { color: var(--text); }
  .footer-bottom {
    border-top: 1px solid var(--glass-border);
    padding-top: 1.5rem;
    display: flex; flex-direction: column; gap: 0.5rem; align-items: flex-start;
  }
  @media (min-width: 640px) { .footer-bottom { flex-direction: row; justify-content: space-between; align-items: center; } }
  .footer-bottom p { font-size: 0.78rem; color: var(--muted); }
  .footer-bottom a { color: var(--muted); text-decoration: none; }
  .dev-credit { font-size: 0.72rem; color: rgba(215,201,201,0.5); }
  .dev-credit a { color: rgba(215,201,201,0.5); }

  /* ─── SIMPLE FADE-IN ───────────────────── */
  .reveal { opacity: 0; transform: translateY(16px); transition: opacity 0.6s ease, transform 0.6s ease; }
  .reveal.visible { opacity: 1; transform: translateY(0); }
</style>
</head>
<body>

<!-- ─────────── NAV ─────────── -->
<nav>
  <a href="/" style="text-decoration: none;">
    <x-logo height="52" />
  </a>
  <div class="nav-links">
    <a href="#services" class="hide-mobile">Services</a>
    <a href="#about" class="hide-mobile">About</a>
    @auth
      <a href="{{ route('dashboard') }}" class="btn-primary">Go to Dashboard</a>
    @else
      <a href="/login" class="hide-mobile" style="color: var(--muted);">Login</a>
      <a href="/register" class="btn-primary">Get Started</a>
    @endauth
  </div>
</nav>

<!-- ─────────── HERO ─────────── -->
<section class="hero">
  <div class="hero-badge">
    <span class="dot"></span>
    Nigeria's Fastest VTU Platform
  </div>

  <h1>Pay Bills. Stay Connected. <span>Save More.</span></h1>

  <p class="hero-sub">
    ⚡ Airtime delivered in under 5 seconds. 💸 Save up to 5% on data bundles. 🔒 Bank-level security via Monnify.
  </p>

  <div class="hero-ctas">
    @auth
      <a href="{{ route('dashboard') }}" class="btn-primary">Return to My Dashboard</a>
    @else
      <a href="/register" class="btn-primary">Start Paying Bills in Seconds</a>
      <a href="#services" class="btn-outline">Explore Rates</a>
    @endauth
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

  <!-- Boxed hero video (drop hero.mp4 + hero-poster.jpg into public/videos) -->
  <div class="hero-video-card">
    <video controls poster="{{ asset('videos/hero-poster.jpg') }}" preload="none">
      <source src="{{ asset('videos/hero.mp4') }}" type="video/mp4">
    </video>
  </div>
</section>

<!-- ─────────── STATS ─────────── -->
<div class="stats-bar">
  <div class="stats-inner">
    <div>
      <div class="stat-value">50,000+</div>
      <div class="stat-label">Transactions Processed</div>
    </div>
    <div>
      <div class="stat-value">10,000+</div>
      <div class="stat-label">Happy Customers</div>
    </div>
    <div>
      <div class="stat-value" style="color: var(--green);">99.9%</div>
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
      <p class="section-sub">From your morning data subscription to monthly electricity token — CodeDragon handles it all at the best prices in Nigeria.</p>
    </div>

    <div class="services-grid">
      <a href="{{ route('register') }}" class="service-card featured reveal">
        <div class="svc-icon">📡</div>
        <div class="svc-name">Data Bundles</div>
        <div class="svc-desc">Cheapest SME & corporate data. Save up to 5% instantly.</div>
      </a>
      <a href="{{ route('register') }}" class="service-card reveal">
        <div class="svc-icon">📱</div>
        <div class="svc-name">Buy Airtime</div>
        <div class="svc-desc">MTN, Airtel, Glo & 9mobile. Delivered in < 5s.</div>
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
        <p>CodeDragon is your ultimate platform for fast, secure, and reliable bill payments. Easily top up your airtime, internet data, renew your cable TV, and pay electricity subscriptions — all from one dashboard.</p>
        <p>We provide all our utility services at the most affordable rates, helping you stay connected while keeping costs low. Designed with ease of use in mind, CodeDragon delivers a highly secure and efficient service that makes everyday digital transactions a breeze.</p>
        <p style="font-size: 0.82rem; color: var(--muted); margin-top: 1.5rem;">
          📍 150 Agbani Road, Enugu South, Enugu State<br>
          📧 support@codedragon.ng
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
  <div class="cta-band-inner">
    <div class="cta-band-content reveal">
      <h2>Ready to Get Started?</h2>
      <p>Join thousands of Nigerians already saving time and money with CodeDragon. It takes less than a minute.</p>
    </div>
    <a href="/register" class="btn-primary reveal">Create Free Account</a>
  </div>
</section>

<!-- ─────────── FOOTER ─────────── -->
<footer>
  <div class="footer-inner">
    <div class="footer-top">
      <div class="footer-brand">
        <a href="/" style="text-decoration: none;">
          <x-logo height="70" />
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
        <a href="mailto:support@codedragon.ng">support@codedragon.ng</a>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© {{ date('Y') }} CodeDragon. All rights reserved. | <a href="/privacy-policy">Privacy</a> · <a href="/terms">Terms</a> · <a href="/refund-policy">Refund Policy</a></p>
      <p class="dev-credit">Developed by <a href="mailto:hoetech.tsc@gmail.com">Hoetech Technical Support — contact: hoetech.tsc@gmail.com</a></p>
    </div>
  </div>
</footer>

<script>
  // Lightweight scroll reveal (fade in once, no exit/re-trigger complexity)
  const reveals = document.querySelectorAll('.reveal');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });
  reveals.forEach(el => observer.observe(el));
</script>
</body>
</html>
