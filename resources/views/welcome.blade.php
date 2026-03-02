<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ config('app.name', 'MultiTenant Manager') }}</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@endif

<style>
    * { box-sizing:border-box; margin:0; padding:0; }
    :root {
        --white:#ffffff;
        --black:#1a1714;
        --muted:#555555;
        --accent:#c8622a;
        --cream:#f9f9f9;
    }

    body {
        font-family:'DM Sans', sans-serif;
        background: var(--cream);
        color: var(--black);
        min-height:100vh;
        display:flex;
        justify-content:center;
        align-items:center;
        padding:2rem;
    }

    .page { max-width:600px; width:100%; text-align:center; }

    .hero { margin-bottom:2rem; }
    .hero img { height:40px; margin-bottom:1rem; }
    .hero h1 { font-family:'Playfair Display', serif; font-size:clamp(2rem,5vw,3rem); font-weight:800; line-height:1.1; }
    .hero h1 em { color:var(--accent); font-style:italic; }
    .hero p { color:var(--muted); font-size:0.95rem; line-height:1.6; margin-top:0.5rem; }

    .card {
        background: var(--white);
        border-radius:20px;
        box-shadow:0 6px 24px rgba(0,0,0,0.08);
        padding:2rem;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover { transform: translateY(-4px); box-shadow:0 12px 32px rgba(0,0,0,0.15); }

    .actions { margin-top:1.5rem; display:flex; justify-content:center; gap:0.75rem; flex-wrap:wrap; }
    .btn { padding:0.65rem 1.5rem; border-radius:12px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:0.3rem; transition: all 0.2s; }
    .btn-dark { background:var(--black); color: var(--white); box-shadow:0 4px 12px rgba(0,0,0,0.12); }
    .btn-dark:hover { background:var(--accent); transform:translateY(-2px); box-shadow:0 6px 16px rgba(0,0,0,0.15); }
    .btn-outline { border:1px solid rgba(0,0,0,0.1); color: var(--muted); }
    .btn-outline:hover { border-color:var(--black); color:var(--black); }

    .footer { margin-top:2rem; font-size:0.7rem; color:var(--muted); display:flex; justify-content:center; gap:0.5rem; flex-wrap:wrap; }
    .footer a { color: var(--muted); text-decoration:none; }
    .footer a:hover { color: var(--black); }
    .footer-sep { width:3px; height:3px; background: rgba(0,0,0,0.15); border-radius:50%; }
</style>
</head>
<body>

<div class="page">

 <div class="hero text-center space-y-4">
    <!-- Centered logo -->
    <div class="flex justify-center">
        <a href="{{ route('dashboard') }}">
            <x-application-logo class="h-12 w-auto fill-current text-black" />
        </a>
    </div>

    <h1 class="text-3xl font-extrabold">
        Welcome to <em class="text-accent">Task Manager App</em>
    </h1>
    <p class="text-gray-600 max-w-md mx-auto">
        Manage all your teams, tenants, and tasks seamlessly from one platform.
    </p>
</div>
    <div class="card">
        <div class="actions">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-dark">Go to Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn btn-dark">Register</a>
                <a href="{{ route('login') }}" class="btn btn-outline">Log In</a>
            @endauth
        </div>
    </div>

    <div class="footer">
        <span>© {{ date('Y') }} {{ config('app.name', 'MultiTenant Manager') }}</span>
        <div class="footer-sep"></div>
        <a href="#">Privacy</a>
        <div class="footer-sep"></div>
        <a href="#">Terms</a>
        <div class="footer-sep"></div>
        <a href="#">Support</a>
    </div>

</div>

</body>
</html>