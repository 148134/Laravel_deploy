<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Admin') — EduPH Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<script>
    const layout = document.querySelector('.layout');
    const error = document.querySelector('.error');
  
    const mediaQuery = window.matchMedia('(max-width: 768px)');

    function handleTabletChange(e) {
      if (e.matches) {
    
      } else {
  
        layout.style.display = 'block'; 
        error.style.display = 'none';
      }
    }

    mediaQuery.addEventListener('change', handleTabletChange);

    handleTabletChange(mediaQuery);

</script>
<div class="error">
    <h1>Bawal selpon badi</h1>
</div>

<div class="layout">


  {{-- ── SIDEBAR ─────────────────────────────────────── --}}
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="brand-tag">Admin Panel</div>
      <div class="brand-name"> UniF<i class="bi bi-search ii"></i>ND</span> DB</div>
    </div>

    <nav class="sidebar-nav">
      <div class="nav-section-label">Overview</div>
      <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-fill"></i> Dashboard
      </a>

      <div class="nav-section-label">Manage</div>
      <a href="{{ route('admin.universities.index') }}" class="{{ request()->routeIs('admin.universities.*') ? 'active' : '' }}">
        <i class="bi bi-buildings-fill"></i> Universities
      </a>
      <a href="{{ route('admin.courses.index') }}" class="{{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
        <i class="bi bi-journal-bookmark-fill"></i> Courses
      </a>
      <a href="{{ route('admin.scholarships.index') }}" class="{{ request()->routeIs('admin.scholarships.*') ? 'active' : '' }}">
        <i class="bi bi-award-fill"></i> Scholarships
      </a>
      <a href="{{ route('admin.accreditation.index') }}" class="{{ request()->routeIs('admin.accreditation.*') ? 'active' : '' }}">
        <i class="bi bi-patch-check-fill"></i> Accreditation
      </a>

      <div class="nav-section-label">Reference</div>
      <a href="{{ route('admin.regions.index') }}" class="{{ request()->routeIs('admin.regions.*') ? 'active' : '' }}">
        <i class="bi bi-map-fill"></i> Regions
      </a>

      <div class="nav-section-label">Site</div>
      <a href="/" target="_blank">
        <i class="bi bi-box-arrow-up-right"></i> View Portal
      </a>
    </nav>

    <div class="sidebar-footer">
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit"><i class="bi bi-box-arrow-left"></i> Sign Out</button>
      </form>
    </div>
  </aside>

  {{-- ── MAIN ─────────────────────────────────────────── --}}
  <main class="main">

    @if(session('success'))
      <div class="flash flash-success"><i class="bi bi-check-circle"></i> {{ session('success') }}</div>
    @endif

    @if(session('error'))
      <div class="flash flash-error"><i class="bi bi-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    @yield('content')

  </main>
</div>

</body>
</html>
