<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Noctura — Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=Fraunces:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Poppins:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

  <style>
  *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

  :root {
    --navy:        #0d1b35;
    --navy-mid:    #152345;
    --navy-light:  #1e3264;
    --navy-xlight: #243a73;
    --white:       #ffffff;
    --off-white:   #f4f6fb;
    --muted:       #8094b4;
    --accent:      #4a8ef5;
    --accent-glow: rgba(74,142,245,0.25);
    --accent-soft: rgba(74,142,245,0.10);
    --border:      rgba(13,27,53,0.09);
    --border-dark: rgba(255,255,255,0.10);
    --text-body:   #334155;
    --text-muted:  #7a8fa8;
  }

  html, body {
    height: 100%;
    font-family: 'Sora', sans-serif;
    background: var(--off-white);
  }

  body {
    display: flex;
    min-height: 100vh;
    overflow-x: hidden;
  }

  /* ═══════════════════════════════
    LEFT — Atmospheric Panel
  ═══════════════════════════════ */
  .left {
    width: 44%;
    flex-shrink: 0;
    background: var(--navy);
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 52px 52px 48px;
  }

  /* Mesh gradient background layers */
  .left-bg {
    position: absolute;
    inset: 0;
    pointer-events: none;
  }
  .left-bg::before {
    content: '';
    position: absolute;
    width: 600px; height: 600px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(74,142,245,0.18) 0%, transparent 65%);
    top: -180px; left: -160px;
  }
  .left-bg::after {
    content: '';
    position: absolute;
    width: 400px; height: 400px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(30,50,100,0.6) 0%, transparent 70%);
    bottom: -80px; right: -80px;
  }
  .left-blob {
    position: absolute;
    width: 280px; height: 280px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(74,142,245,0.12) 0%, transparent 70%);
    bottom: 120px; left: -60px;
    pointer-events: none;
  }

  canvas#c {
    position: absolute;
    inset: 0;
    pointer-events: none;
    opacity: 0.55;
  }

  /* Subtle grid overlay */
  .left-grid {
    position: absolute;
    inset: 0;
    background-image:
      linear-gradient(rgba(255,255,255,0.022) 1px, transparent 1px),
      linear-gradient(90deg, rgba(255,255,255,0.022) 1px, transparent 1px);
    background-size: 40px 40px;
    pointer-events: none;
  }

  /* Brand */
  .brand {
    position: relative;
    z-index: 2;
  }
  .brand-logo {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 0;
  }
  .moon-icon {
    width: 48px; height: 48px;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.14);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(12px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.3), inset 0 1px 0 rgba(255,255,255,0.1);
  }
  .moon-icon svg {
    filter: drop-shadow(0 0 8px rgba(255,255,255,0.35));
  }
  .brand-text .name {
    font-family: 'Fraunces', serif;
    font-size: 22px;
    font-weight: 700;
    color: #fff;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    line-height: 1;
  }
  .brand-text .tagline {
    font-size: 10px;
    font-weight: 400;
    letter-spacing: 0.28em;
    text-transform: uppercase;
    color: var(--accent);
    margin-top: 5px;
    opacity: 0.85;
  }

  /* Center hero copy */
  .left-hero {
    position: relative;
    z-index: 2;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 48px 0 32px;
  }
  .left-eyebrow {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.28em;
    text-transform: uppercase;
    color: var(--accent);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .left-eyebrow::before {
    content: '';
    display: block;
    width: 24px; height: 1.5px;
    background: var(--accent);
    opacity: 0.7;
  }
  .left-headline {
    font-family: 'Fraunces', serif;
    font-size: clamp(36px, 3.2vw, 50px);
    font-weight: 700;
    color: #fff;
    line-height: 1.12;
    margin-bottom: 22px;
    letter-spacing: -0.01em;
  }
  .left-headline em {
    font-style: italic;
    color: rgba(255,255,255,0.55);
  }
  .left-body {
    font-size: 13.5px;
    color: rgba(255,255,255,0.38);
    line-height: 1.8;
    max-width: 300px;
    font-weight: 300;
  }

  /* Bottom stats strip */
  .left-stats {
    position: relative;
    z-index: 2;
    display: flex;
    gap: 0;
    border-top: 1px solid rgba(255,255,255,0.07);
    padding-top: 28px;
  }
  .stat-item {
    flex: 1;
    padding-right: 24px;
  }
  .stat-item + .stat-item {
    padding-left: 24px;
    padding-right: 0;
    border-left: 1px solid rgba(255,255,255,0.07);
  }
  .stat-num {
    font-family: 'Fraunces', serif;
    font-size: 26px;
    font-weight: 600;
    color: #fff;
    line-height: 1;
    margin-bottom: 5px;
  }
  .stat-lbl {
    font-size: 10.5px;
    color: rgba(255,255,255,0.3);
    letter-spacing: 0.06em;
    text-transform: uppercase;
  }

  /* ═══════════════════════════════
    RIGHT — Form Panel
  ═══════════════════════════════ */
  .right {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 48px 40px;
    background: var(--white);
    position: relative;
  }

  /* Subtle background pattern */
  .right::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(rgba(74,142,245,0.045) 1px, transparent 1px);
    background-size: 28px 28px;
    pointer-events: none;
  }

  .form-wrap {
    width: 100%;
    max-width: 420px;
    position: relative;
    z-index: 1;
  }

  /* Form header */
  .form-top {
    margin-bottom: 36px;
  }
  .form-pretitle {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: var(--accent-soft);
    border: 1px solid rgba(74,142,245,0.18);
    color: var(--accent);
    font-size: 10.5px;
    font-weight: 600;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    padding: 5px 12px;
    border-radius: 30px;
    margin-bottom: 18px;
  }
  .form-pretitle::before {
    content: '';
    width: 6px; height: 6px;
    background: var(--accent);
    border-radius: 50%;
    animation: pulse 2s ease infinite;
  }
  @keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(0.8); }
  }
  .form-title {
    font-family: 'Fraunces', serif;
    font-size: 38px;
    font-weight: 700;
    color: var(--navy);
    line-height: 1.1;
    margin-bottom: 10px;
    letter-spacing: -0.02em;
  }
  .form-title span {
    color: var(--accent);
    font-style: italic;
  }
  .form-sub {
    font-size: 13.5px;
    color: var(--text-muted);
    line-height: 1.6;
    font-weight: 400;
  }

  /* Alerts */
  .alert-error, .alert-success {
    display: flex;
    align-items: center;
    gap: 10px;
    border-radius: 12px;
    padding: 13px 16px;
    font-size: 13px;
    margin-bottom: 22px;
    font-weight: 500;
    animation: slideDown 0.3s cubic-bezier(.4,0,.2,1);
  }
  .alert-error {
    background: #fff5f5;
    border: 1.5px solid #fecaca;
    color: #b91c1c;
  }
  .alert-success {
    background: #f0fdf4;
    border: 1.5px solid #bbf7d0;
    color: #166534;
  }
  @keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* Fields */
  .field-group {
    display: flex;
    flex-direction: column;
    gap: 16px;
    margin-bottom: 16px;
  }
  .field {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }
  .field label {
    font-size: 11px;
    font-weight: 600;
    color: var(--navy);
    letter-spacing: 0.1em;
    text-transform: uppercase;
  }
  .input-wrap {
    position: relative;
    display: flex;
    align-items: center;
  }
  .input-icon {
    position: absolute;
    left: 15px;
    color: #b0c0d8;
    display: flex;
    align-items: center;
    pointer-events: none;
    transition: color .2s;
  }
  .input-wrap:focus-within .input-icon { color: var(--accent); }

  input[type="text"],
  input[type="password"],
  input[type="email"] {
    width: 100%;
    padding: 14px 46px 14px 44px;
    border: 1.5px solid #e2e8f3;
    border-radius: 12px;
    background: #f8fafd;
    color: var(--navy);
    font-family: 'Sora', sans-serif;
    font-size: 14px;
    font-weight: 400;
    outline: none;
    transition: border-color .2s, box-shadow .2s, background .2s;
  }
  input::placeholder { color: #b8c6d9; font-size: 13px; }
  input:focus {
    border-color: var(--accent);
    background: #fff;
    box-shadow: 0 0 0 4px rgba(74,142,245,0.09);
  }
  input.is-error {
    border-color: #fca5a5 !important;
    background: #fff5f5 !important;
  }
  .field-error {
    font-size: 11.5px;
    color: #e53e3e;
    display: flex;
    align-items: center;
    gap: 5px;
  }

  .eye-btn {
    position: absolute;
    right: 13px;
    background: none;
    border: none;
    cursor: pointer;
    color: #b0c0d8;
    display: flex;
    align-items: center;
    padding: 4px;
    transition: color .2s;
    border-radius: 6px;
  }
  .eye-btn:hover { color: var(--navy); background: rgba(13,27,53,0.05); }

  /* Options row */
  .opts {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
  }
  .chk-label {
    display: flex;
    align-items: center;
    gap: 9px;
    cursor: pointer;
    user-select: none;
  }
  .chk-label input { display: none; }
  .chk-box {
    width: 18px; height: 18px;
    border: 1.5px solid #d1dae7;
    border-radius: 5px;
    background: #fff;
    display: flex; align-items: center; justify-content: center;
    transition: all .2s;
    flex-shrink: 0;
  }
  .chk-label input:checked ~ .chk-box {
    background: var(--accent);
    border-color: var(--accent);
  }
  .chk-text { font-size: 13px; color: var(--text-muted); font-weight: 400; }
  .forgot {
    font-size: 12.5px;
    color: var(--accent);
    text-decoration: none;
    font-weight: 600;
    letter-spacing: 0.02em;
    transition: opacity .2s;
  }
  .forgot:hover { opacity: .7; }

  /* Submit button */
  .btn-submit {
    width: 100%;
    padding: 15px 24px;
    background: var(--navy);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-family: 'Sora', sans-serif;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    cursor: pointer;
    transition: background .2s, transform .15s, box-shadow .2s;
    box-shadow: 0 4px 24px rgba(13,27,53,0.22);
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
  }
  .btn-submit::before {
    content: '';
    position: absolute;
    top: 0; left: -100%;
    width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.06), transparent);
    transition: left .5s;
  }
  .btn-submit:hover {
    background: #1a2e58;
    transform: translateY(-1px);
    box-shadow: 0 8px 32px rgba(13,27,53,0.30);
  }
  .btn-submit:hover::before { left: 100%; }
  .btn-submit:active { transform: translateY(0); }

  /* Divider */
  .divider {
    display: flex;
    align-items: center;
    gap: 14px;
    margin: 22px 0;
  }
  .divider::before, .divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #e8edf5;
  }
  .divider span {
    font-size: 11px;
    color: #b0bec9;
    font-weight: 500;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    white-space: nowrap;
  }

  /* Footer note */
  .form-note {
    text-align: center;
    font-size: 12px;
    color: #b0bec9;
    margin-top: 28px;
    line-height: 1.6;
  }
  .form-note a {
    color: var(--accent);
    text-decoration: none;
    font-weight: 600;
  }

  /* ── RESPONSIVE ── */
  @media (max-width: 900px) {
    .left { width: 38%; padding: 40px 36px; }
    .left-stats { flex-direction: column; gap: 16px; }
    .stat-item + .stat-item { border-left: none; padding-left: 0; border-top: 1px solid rgba(255,255,255,0.07); padding-top: 16px; }
  }
  @media (max-width: 720px) {
    .left { display: none; }
    .right { background: var(--off-white); }
    body { background: var(--off-white); }
    .form-wrap { max-width: 100%; }
  }

  /* Entrance animations */
  .form-wrap > * {
    opacity: 0;
    transform: translateY(16px);
    animation: fadeUp 0.5s cubic-bezier(.4,0,.2,1) forwards;
  }
  .form-wrap > *:nth-child(1) { animation-delay: .05s; }
  .form-wrap > *:nth-child(2) { animation-delay: .12s; }
  .form-wrap > *:nth-child(3) { animation-delay: .18s; }
  .form-wrap > *:nth-child(4) { animation-delay: .24s; }
  .form-wrap > *:nth-child(5) { animation-delay: .30s; }
  .form-wrap > *:nth-child(6) { animation-delay: .36s; }

  @keyframes fadeUp {
    to { opacity: 1; transform: translateY(0); }
  }
</style>

    @stack('styles')
</head>

<body>
    <div class="sidebar-overlay"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-logo">
                <div class="brand-icon">
                    <div class="sidebar-moon-icon">
                        <svg width="26" height="26" viewBox="0 0 38 38" fill="none">
                            <path d="M22 6C17.6 6.9 14.3 10.8 14.3 15.5C14.3 20.9 18.6 25.2 24 25.2C26.2 25.2 28.2 24.5 29.8 23.3C28.3 27.9 24 31.2 19 31.2C12.4 31.2 7 25.8 7 19.2C7 12.6 12.4 7.2 19 7.2C20 7.2 21 7.3 22 6Z" fill="white"/>
                            <circle cx="27" cy="9" r="1.2" fill="white" opacity="0.7"/>
                            <circle cx="31" cy="15" r="0.8" fill="white" opacity="0.5"/>
                            <circle cx="25" cy="5" r="0.7" fill="white" opacity="0.5"/>
                        </svg>
                    </div>
                </div>
                <span class="brand-name">Noctura</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Main Menu</div>

            <a href="{{ route('dashboard') }}" class="nav-item active" data-nav="dashboard">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
                <span>Dashboard</span>
            </a>

            <div class="nav-group" id="masterDataGroup">
                <div class="nav-item master-data-trigger">
                    <div class="trigger-text">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <ellipse cx="12" cy="5" rx="9" ry="3" />
                            <path d="M3 5v14c0 1.66 4.03 3 9 3s9-1.34 9-3V5" />
                            <path d="M3 12c0 1.66 4.03 3 9 3s9-1.34 9-3" />
                        </svg>
                        <span>Master Data</span>
                    </div>
                    <svg class="dropdown-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </div>
                <div class="sub-nav">
                    <div class="flyout-title">Master Data</div>
                    <a href="{{ route('akun.index') }}" class="sub-nav-item" data-sub="akun">
                        <svg class="sub-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        <span>Kelola Akun</span>
                    </a>
                    <a href="{{ route('pertanyaan') }}" class="sub-nav-item" data-sub="question">
                        <svg class="sub-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
                            <line x1="12" y1="17" x2="12.01" y2="17" />
                        </svg>
                        <span>Kelola Pertanyaan</span>
                    </a>
                    <a href="{{ route('jawaban') }}" class="sub-nav-item" data-sub="answer">
                        <svg class="sub-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                        </svg>
                        <span>Kelola Jawaban</span>
                    </a>
                    <a href="{{ route('edukasi.index') }}" class="sub-nav-item" data-sub="edu">
                        <svg class="sub-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                        </svg>
                        <span>Kelola Edukasi</span>
                    </a>
                </div>
            </div>

            <a href="{{ route('visualisasi') }}" class="nav-item {{ request()->routeIs('visualisasi') ? 'active' : '' }}" data-nav="visualisasi">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="9" width="4" height="12" rx="1" />
                    <rect x="10" y="5" width="4" height="16" rx="1" />
                    <rect x="17" y="2" width="4" height="19" rx="1" />
                </svg>
                <span>Visualisasi</span>
            </a>

            <a href="{{ route('monitoring') }}" class="nav-item {{ request()->routeIs('monitoring') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M19.07 4.93A10 10 0 1 1 4.93 19.07"/>
                    <path d="M12 2v2M12 20v2M2 12h2M20 12h2"/>
                </svg>
                <span>Monitoring Prediksi</span>
            </a>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <header class="topbar">
            <button class="sidebar-toggle-btn" id="sidebarToggleBtn" title="Toggle Sidebar">
                <svg class="toggle-icon" id="toggleIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
            </button>

            <button class="mobile-menu-toggle" id="mobileMenuToggle">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="3" y1="12" x2="21" y2="12" />
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <line x1="3" y1="18" x2="21" y2="18" />
                </svg>
            </button>

            <div class="topbar-divider"></div>

            <div class="topbar-search">
                <span class="search-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.35-4.35" />
                    </svg>
                </span>
                <input type="text" placeholder="Cari sesuatu...">
            </div>

            <div class="topbar-actions">
                <!-- Notification Button -->
                <div class="icon-btn">
                    <div class="notif-dot"></div>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                        <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                    </svg>
                </div>

                <!-- Profile Button with Dropdown -->
                <div class="icon-btn profile-btn" id="profileBtn" title="Profil">
                    <div class="profile-icon-wrapper">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>

                    <!-- Dropdown Menu -->
                    <div class="profile-dropdown" id="profileDropdown">
                        <div class="dropdown-header">
                            <div class="dropdown-avatar">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </div>
                            <div>
                                <div class="dropdown-name">{{ auth()->user()->name ?? 'Dr. Setiawan' }}</div>
                                <div class="dropdown-email">{{ auth()->user()->email ?? 'dr.setiawan@noctura.id' }}</div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>

                        <button type="button" class="dropdown-item" id="openProfileModal">
                            <svg class="dropdown-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <span>Profil Saya</span>
                        </button>

                        <button type="button" class="dropdown-item" id="openSettingsModal">
                            <svg class="dropdown-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="3"/>
                                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                            </svg>
                            <span>Pengaturan</span>
                        </button>

                        <div class="dropdown-divider"></div>

                        <form action="{{ route('logout') }}" method="POST" id="logoutForm" onsubmit="handleLogoutSubmit(event)">
                            @csrf
                            <button type="submit" class="dropdown-item dropdown-logout" id="logoutBtn">
                                <svg class="dropdown-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                    <polyline points="16 17 21 12 16 7"/>
                                    <line x1="21" y1="12" x2="9" y2="12"/>
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="dashboard-body" id="mainContent">
            @yield('content')
        </main>
    </div>

    <!-- ========== PROFILE MODAL ========== -->
    <div class="modal-overlay" id="profileModal">
        <div class="modal-container">
            <div class="modal-header">
                <h3 class="modal-title">Profil Saya</h3>
                <button class="modal-close" id="closeProfileModal" aria-label="Tutup modal">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="profile-avatar-section">
                    <div class="profile-avatar-large">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                </div>
                <div class="profile-view">
                    <div class="profile-row">
                        <label>Nama Lengkap</label>
                        <div class="profile-value">{{ auth()->user()->name ?? '-' }}</div>
                    </div>
                    <div class="profile-row">
                        <label>Email</label>
                        <div class="profile-value">{{ auth()->user()->email ?? '-' }}</div>
                    </div>
                    <div class="profile-row">
                        <label>Role</label>
                        <div class="profile-value">Sleep Specialist</div>
                    </div>
                    <div class="profile-row">
                        <label>Terdaftar Sejak</label>
                        <div class="profile-value">
                            {{ auth()->user()->created_at?->format('d F Y') ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeProfileBtn">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        (function() {
            'use strict';

            const body            = document.body;
            const toggleBtn       = document.getElementById('sidebarToggleBtn');
            const mobileToggle    = document.getElementById('mobileMenuToggle');
            const overlay         = document.querySelector('.sidebar-overlay');
            const toggleIcon      = document.getElementById('toggleIcon');
            const masterGroup     = document.getElementById('masterDataGroup');
            const trigger         = document.querySelector('.master-data-trigger');
            const subNavOriginal  = masterGroup?.querySelector('.sub-nav');
            const profileBtn      = document.getElementById('profileBtn');
            const profileDropdown = document.getElementById('profileDropdown');
            const profileModal    = document.getElementById('profileModal');
            const settingsModal   = document.getElementById('settingsModal');
            const openProfileBtn  = document.getElementById('openProfileModal');
            const openSettingsBtn = document.getElementById('openSettingsModal');
            const closeProfileBtn = document.getElementById('closeProfileModal');
            const closeSettingsBtn       = document.getElementById('closeSettingsModal');
            const cancelSettingsBtn      = document.getElementById('cancelSettings');
            const closeProfileFooterBtn  = document.getElementById('closeProfileBtn');

            let flyoutEl = null;

            // ── Flyout ──
            function buildFlyout() {
                if (flyoutEl || !subNavOriginal) return;
                flyoutEl = document.createElement('div');
                flyoutEl.className = 'sub-nav-flyout';
                flyoutEl.innerHTML = subNavOriginal.innerHTML;
                document.body.appendChild(flyoutEl);
                flyoutEl.querySelectorAll('.sub-nav-item').forEach(item => {
                    item.addEventListener('click', () => {
                        const sub = item.dataset.sub;
                        document.querySelectorAll('.nav-item, .sub-nav-item').forEach(el => el.classList.remove('active'));
                        item.classList.add('active');
                        const mirror = subNavOriginal.querySelector(`[data-sub="${sub}"]`);
                        if (mirror) mirror.classList.add('active');
                        closeFlyout();
                    });
                });
            }

            function openFlyout() {
                if (!trigger) return;
                buildFlyout();
                const rect = trigger.getBoundingClientRect();
                const viewH = window.innerHeight;
                const flyH = 220;
                let topPos = rect.top;
                if (topPos + flyH > viewH - 16) topPos = viewH - flyH - 16;
                const arrowTop = (rect.top + rect.height / 2) - topPos - 6;
                flyoutEl.style.top = topPos + 'px';
                flyoutEl.style.setProperty('--arrow-top', arrowTop + 'px');
                requestAnimationFrame(() => flyoutEl?.classList.add('visible'));
            }

            function closeFlyout() {
                if (!flyoutEl) return;
                flyoutEl.classList.remove('visible');
                if (masterGroup) masterGroup.classList.remove('open');
            }

            // ── Dropdown ──
            function closeProfileDropdown() {
                profileDropdown?.classList.remove('visible');
                profileBtn?.classList.remove('active');
            }

            function toggleProfileDropdown(e) {
                if (e) { e.stopPropagation(); e.preventDefault(); }
                if (!profileDropdown) return;
                const isVisible = profileDropdown.classList.contains('visible');
                closeFlyout();
                if (isVisible) { closeProfileDropdown(); }
                else { closeProfileDropdown(); profileDropdown.classList.add('visible'); profileBtn?.classList.add('active'); }
            }

            // ── Modals ──
            function openModal(modal) {
                if (!modal) return;
                closeProfileDropdown();
                modal.classList.add('visible');
                document.body.style.overflow = 'hidden';
            }

            function closeModal(modal) {
                if (!modal) return;
                modal.classList.remove('visible');
                document.body.style.overflow = '';
            }

            // ── Logout ──
            window.handleLogoutSubmit = function() { closeProfileDropdown(); return true; };

            document.addEventListener('DOMContentLoaded', function() {
                const logoutBtn  = document.getElementById('logoutBtn');
                const logoutForm = document.getElementById('logoutForm');
                if (logoutBtn && logoutForm) {
                    logoutBtn.addEventListener('click', function() {
                        setTimeout(() => { logoutForm.removeEventListener('submit', window.handleLogoutSubmit); logoutForm.submit(); }, 150);
                    });
                }
            });

            // ── Flash ──
            function showFlashMessage(message, type = 'info') {
                const existing = document.querySelector('.flash-message');
                if (existing) existing.remove();
                const flash = document.createElement('div');
                flash.className = `flash-message flash-${type}`;
                let iconSvg = '<circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>';
                if (type === 'success') iconSvg = '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>';
                if (type === 'error')   iconSvg = '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>';
                flash.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">${iconSvg}</svg><span>${message}</span><button class="flash-close">&times;</button>`;
                const colors = { success: { bg:'#ecfdf5',border:'#a7f3d0',text:'#065f46' }, error: { bg:'#fef2f2',border:'#fecaca',text:'#991b1b' }, info: { bg:'#eff6ff',border:'#bfdbfe',text:'#1e40af' } };
                const c = colors[type] || colors.info;
                Object.assign(flash.style, { position:'fixed', top:'20px', right:'20px', padding:'12px 16px', background:c.bg, border:`1.5px solid ${c.border}`, borderRadius:'12px', color:c.text, fontSize:'13px', fontWeight:'500', display:'flex', alignItems:'center', gap:'10px', zIndex:'5000', boxShadow:'0 4px 16px rgba(0,0,0,0.1)', animation:'slideIn 0.3s ease' });
                const closeBtn = flash.querySelector('.flash-close');
                if (closeBtn) { Object.assign(closeBtn.style, { background:'none', border:'none', color:'inherit', fontSize:'18px', cursor:'pointer', marginLeft:'8px', opacity:'0.7' }); closeBtn.addEventListener('click', () => flash.remove()); }
                document.body.appendChild(flash);
                setTimeout(() => { flash.style.animation = 'slideOut 0.3s ease'; setTimeout(() => flash.remove(), 300); }, 4000);
            }

            // ── Sidebar ──
            function isCollapsed() { return body.classList.contains('sidebar-collapsed'); }
            function updateToggleIcon() {
                if (!toggleIcon) return;
                toggleIcon.innerHTML = isCollapsed() ? '<polyline points="9 18 15 12 9 6"/>' : '<polyline points="15 18 9 12 15 6"/>';
            }

            // ── Active state ──
            const navItems = document.querySelectorAll('.nav-item[data-nav]');
            const subItems = document.querySelectorAll('.sub-nav-item');

            function clearActive() { navItems.forEach(i => i.classList.remove('active')); subItems.forEach(s => s.classList.remove('active')); }
            function setActiveFromUrl() {
                clearActive();
                const currentPath = window.location.pathname;
                subItems.forEach(el => {
                    const href = el.getAttribute('href');
                    if (href && currentPath === new URL(href, window.location.origin).pathname) {
                        el.classList.add('active');
                        if (el.closest('.sub-nav') && masterGroup) masterGroup.classList.add('open');
                    }
                });
                navItems.forEach(el => {
                    const href = el.getAttribute('href');
                    if (href && currentPath === new URL(href, window.location.origin).pathname) el.classList.add('active');
                });
            }

            // ── Init ──
            if (localStorage.getItem('sidebarCollapsed') === 'true') body.classList.add('sidebar-collapsed');
            updateToggleIcon();
            setActiveFromUrl();

            if (toggleBtn) {
                toggleBtn.addEventListener('click', e => {
                    e.stopPropagation();
                    closeFlyout(); closeProfileDropdown();
                    if (masterGroup) masterGroup.classList.remove('open');
                    body.classList.toggle('sidebar-collapsed');
                    localStorage.setItem('sidebarCollapsed', isCollapsed());
                    updateToggleIcon();
                });
            }

            const closeSidebar = () => body.classList.remove('sidebar-open');
            if (mobileToggle) mobileToggle.addEventListener('click', () => body.classList.toggle('sidebar-open'));
            if (overlay) overlay.addEventListener('click', closeSidebar);

            document.addEventListener('click', e => {
                if (window.innerWidth <= 768) {
                    const sidebar = document.querySelector('.sidebar');
                    if (sidebar && !sidebar.contains(e.target) && !(mobileToggle && mobileToggle.contains(e.target)) && body.classList.contains('sidebar-open')) closeSidebar();
                }
                if (flyoutEl?.classList.contains('visible') && !flyoutEl.contains(e.target) && trigger && !trigger.contains(e.target)) closeFlyout();
                if (profileDropdown?.classList.contains('visible') && !profileDropdown.contains(e.target) && profileBtn && !profileBtn.contains(e.target)) closeProfileDropdown();
                if (profileModal && e.target === profileModal) closeModal(profileModal);
                if (settingsModal && e.target === settingsModal) closeModal(settingsModal);
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth > 768) closeSidebar();
                if (flyoutEl?.classList.contains('visible')) openFlyout();
                if (window.innerWidth <= 768) closeProfileDropdown();
            });

            if (trigger) {
                trigger.addEventListener('click', e => {
                    e.preventDefault(); e.stopPropagation(); closeProfileDropdown();
                    if (isCollapsed()) {
                        if (flyoutEl?.classList.contains('visible')) closeFlyout();
                        else { openFlyout(); if (masterGroup) masterGroup.classList.add('open'); }
                    } else {
                        if (flyoutEl) closeFlyout();
                        if (masterGroup) masterGroup.classList.toggle('open');
                    }
                });
            }

            if (profileBtn) profileBtn.addEventListener('click', toggleProfileDropdown);
            navItems.forEach(item => item.addEventListener('click', function() { clearActive(); this.classList.add('active'); }));
            subItems.forEach(sub  => sub.addEventListener('click', function()  { clearActive(); this.classList.add('active'); }));
            window.addEventListener('popstate', setActiveFromUrl);

            if (openProfileBtn)       openProfileBtn.addEventListener('click',  e => { e.preventDefault(); openModal(profileModal); });
            if (closeProfileBtn)      closeProfileBtn.addEventListener('click',      () => closeModal(profileModal));
            if (closeProfileFooterBtn) closeProfileFooterBtn.addEventListener('click', () => closeModal(profileModal));

            if (openSettingsBtn) {
                openSettingsBtn.addEventListener('click', e => {
                    e.preventDefault();
                    showFlashMessage('Fitur pengaturan akan segera hadir!', 'info');
                });
            }
            if (closeSettingsBtn)  closeSettingsBtn.addEventListener('click',  () => closeModal(settingsModal));
            if (cancelSettingsBtn) cancelSettingsBtn.addEventListener('click', () => closeModal(settingsModal));
            if (profileModal) profileModal.addEventListener('click', e => { if (e.target === profileModal) closeModal(profileModal); });
            if (settingsModal) settingsModal.addEventListener('click', e => { if (e.target === settingsModal) closeModal(settingsModal); });
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') { closeModal(profileModal); closeModal(settingsModal); closeProfileDropdown(); }
            });

            if (!document.querySelector('#flash-styles')) {
                const style = document.createElement('style');
                style.id = 'flash-styles';
                style.textContent = `@keyframes slideIn{from{transform:translateX(100%);opacity:0}to{transform:translateX(0);opacity:1}}@keyframes slideOut{from{transform:translateX(0);opacity:1}to{transform:translateX(100%);opacity:0}}`;
                document.head.appendChild(style);
            }
        })();
    </script>
    @stack('scripts')
</body>

</html>
