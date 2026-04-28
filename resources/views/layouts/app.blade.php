<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'UniFind Portal') – Philippines Higher Education Directory</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="{{ asset('css/design0.css') }}">
  {{-- <link rel="stylesheet" href="{{ asset('css/portal.css') }}"> --}}
</head>
<body>

{{-- ── TOP NAV ──────────────────────────────────────────────── --}}
<nav>
  <div class="nav-inner">

    {{-- Hamburger (mobile) --}}
    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Open menu" aria-expanded="false">
      <span class="burger">
        <span class="bar" style="color:#b48ef4"></span>
        <span class="bar" style="color:#dc2626"></span>
        <span class="bar" style="color:#00be46"></span>
      </span>
    </button>

    <a href="{{ route('home') }}" class="logo">
      UniF<i class="bi bi-search ii"></i>ND <span>Portal</span>
    </a>

    <div class="nav-links">
      <a href="{{ route('home') }}"         class="{{ request()->routeIs('home')         ? 'active' : '' }}">Dashboard</a>
      <a href="{{ route('universities') }}"  class="{{ request()->routeIs('universities') || request()->routeIs('university') ? 'active' : '' }}">Universities</a>
      <a href="{{ route('courses') }}"       class="{{ request()->routeIs('courses')      ? 'active' : '' }}">Course Finder</a>
      <a href="{{ route('regions') }}"       class="{{ request()->routeIs('regions')      ? 'active' : '' }}">By Region</a>
    </div>

    <span class="nav-flag">🇵🇭</span>
  </div>
</nav>

{{-- ── MOBILE SIDEBAR ────────────────────────────────────────── --}}
<div class="sidebar-overlay" id="sidebarOverlay"></div>
<aside class="sidebar-panel" id="sidebarPanel" aria-label="Mobile navigation">
  <div class="sidebar-header">
    <a href="{{ route('home') }}" class="logo">UniF<i class="bi bi-search"></i>ND <span>Portal</span></a>
    <button class="sidebar-close" id="sidebarClose" aria-label="Close menu">✕</button>
  </div>
  <nav class="sidebar-nav">
    <a href="{{ route('home') }}"         class="{{ request()->routeIs('home')         ? 'active' : '' }}"><span class="nav-icon"><i class="bi bi-house-fill"></i></span> Dashboard</a>
    <a href="{{ route('universities') }}"  class="{{ request()->routeIs('universities') || request()->routeIs('university') ? 'active' : '' }}"><span class="nav-icon"><i class="bi bi-buildings-fill"></i></span> Universities</a>
    <a href="{{ route('courses') }}"       class="{{ request()->routeIs('courses')      ? 'active' : '' }}"><span class="nav-icon"><i class="bi bi-journal"></i></span> Course Finder</a>
    <a href="{{ route('regions') }}"       class="{{ request()->routeIs('regions')      ? 'active' : '' }}"><span class="nav-icon"><i class="bi bi-map"></i></span> By Region</a>
  </nav>
  <div class="sidebar-footer">🇵🇭 Philippines HEI Directory</div>
</aside>

{{-- ── PAGE CONTENT ──────────────────────────────────────────── --}}
@yield('content')

{{-- ── FOOTER ───────────────────────────────────────────────── --}}
<footer>
  <div class="wrap">
    <p><strong>Unifind</strong> &mdash; Philippines Higher Education Directory</p>
    <p style="margin-top:6px">Data sourced from CHED-accredited institutions &bull; 2,400+ HEIs &bull; All 17 Regions</p>
    <p style="margin-top:6px;opacity:.5">RA 10931 – Universal Access to Quality Tertiary Education Act</p>
  </div>
</footer>

<script>
  const toggle  = document.getElementById('sidebarToggle');
  const panel   = document.getElementById('sidebarPanel');
  const overlay = document.getElementById('sidebarOverlay');
  const closeBtn= document.getElementById('sidebarClose');

  function openSidebar()  { panel.classList.add('open'); overlay.classList.add('visible'); toggle.setAttribute('aria-expanded','true'); document.body.style.overflow='hidden'; }
  function closeSidebar() { panel.classList.remove('open'); overlay.classList.remove('visible'); toggle.setAttribute('aria-expanded','false'); document.body.style.overflow=''; }

  toggle.addEventListener('click', () => panel.classList.contains('open') ? closeSidebar() : openSidebar());
  closeBtn.addEventListener('click', closeSidebar);
  overlay.addEventListener('click', closeSidebar);
  document.addEventListener('keydown', e => { if (e.key==='Escape') closeSidebar(); });

  const mq = window.matchMedia('(max-width:700px)');
  function handleBreakpoint(e) { toggle.style.display = e.matches ? 'flex' : 'none'; }
  handleBreakpoint(mq);
  mq.addEventListener('change', handleBreakpoint);
</script>

@stack('scripts')
</body>
</html>
