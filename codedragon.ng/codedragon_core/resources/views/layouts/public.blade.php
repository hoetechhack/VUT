<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $title ?? 'CodeDragon' }}</title>
<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --bg: #0a0505;
    --purple: #B91C1C;
    --purple-bright: #E11D2E;
    --text: #ffffff;
    --muted: #d7c9c9;
    --glass: rgba(20, 10, 10, 0.7);
    --glass-border: rgba(255, 255, 255, 0.12);
  }
  body {
    background: radial-gradient(circle at 20% 30%, rgba(185, 28, 28, 0.12), transparent 40%), var(--bg);
    color: var(--text);
    font-family: 'Inter', sans-serif;
    font-size: 18px;
    line-height: 1.6;
    min-height: 100vh;
  }
  nav {
    position: fixed; top: 0; left: 0; right: 0; z-index: 100;
    background: var(--glass); backdrop-filter: blur(15px); -webkit-backdrop-filter: blur(15px);
    border-bottom: 1px solid var(--glass-border); height: 90px;
    display: flex; align-items: center; justify-content: space-between; padding: 0 2rem;
  }
  .logo { display: flex; align-items: center; text-decoration: none; }
  .nav-links { display: flex; align-items: center; gap: 2rem; }
  .nav-links a { color: #ffffff; text-decoration: none; font-size: 0.95rem; font-weight: 700; transition: color 0.2s; }
  .nav-links a:hover { color: var(--purple-bright); }
  .btn-primary {
    background: linear-gradient(135deg, var(--purple), var(--purple-bright));
    color: #fff; text-decoration: none; font-weight: 800; padding: 0.7rem 1.6rem; border-radius: 12px;
  }
  .content-wrapper { position: relative; z-index: 1; padding: 130px 1.5rem 60px; max-width: 800px; margin: 0 auto; }
  footer { border-top: 1px solid var(--glass-border); padding: 2rem 1.5rem; text-align: center; color: var(--muted); font-size: 0.8rem; }
</style>
</head>
<body>
<nav>
  <a href="/" class="logo" style="text-decoration: none;">
    <x-logo height="56" />
  </a>
  <div class="nav-links">
    <a href="/">Home</a>
    @auth
        <a href="/dashboard">Dashboard</a>
    @else
        <a href="/login">Login</a>
        <a href="/register" class="btn-primary">Get Started</a>
    @endauth
  </div>
</nav>
<div class="content-wrapper">
    {{ $slot }}
</div>
<footer>
    &copy; {{ date('Y') }} CodeDragon. All rights reserved.
</footer>
</body>
</html>
