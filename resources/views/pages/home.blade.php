@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="wrap">

        <div class="hero fade-up">
            <div class="hero-eyebrow">CHED-Accredited Institutions</div>
            <h1>Philippines <em style="text-shadow:1px 4px 2px var(--border2)">Higher Education</em><br>Directory</h1>
            <p>Browse 2,400+ CHED-accredited universities, colleges, and institutions across all 17 regions of the
                Philippines.</p>

            <form method="GET" action="{{ route('universities') }}">
                <div class="search-main">
                    <input type="text" name="q" placeholder="University name or city…" required>
                    <button type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>

            <div class="quick-actions">
                <a href="{{ route('universities') }}" class="btn btn-primary" style="background:#ba95f9">
                    <i class="bi bi-buildings-fill"></i> Browse Universities
                </a>
                <a href="{{ route('courses') }}" class="btn btn-primary" style="background:#57e089">
                    <i class="bi bi-journal"></i> Find a Course
                </a>
                <a href="{{ route('regions') }}" class="btn btn-primary" style="background:#f87979">
                    <i class="bi bi-map"></i> Explore Regions
                </a>
            </div>
        </div>

        @if (!empty((array) $stats))
            <div class="stats-grid fade-up fade-up-d1">
                <div class="stat-card">
                    <div class="stat-num" style="color: var(--purple);">{{ number_format($stats['total_universities']) }}
                    </div>
                    <div class="stat-label">Universities &amp; Colleges</div>
                </div>
                <div class="stat-card">
                    <div class="stat-num">{{ number_format($stats['total_courses']) }}</div>
                    <div class="stat-label">Degree Programs</div>
                </div>
                <div class="stat-card">
                    <div class="stat-num">{{ number_format($stats['total_regions']) }}</div>
                    <div class="stat-label">Regions Covered</div>
                </div>
                <div class="stat-card">
                    <div class="stat-num" style="color: var(--green);">{{ number_format($stats['free_tuition_schools']) }}
                    </div>
                    <div class="stat-label">Free Tuition Schools</div>
                </div>
                <div class="stat-card">
                    <div class="stat-num" style="color: var(--red);">{{ number_format($stats['private_schools']) }}</div>
                    <div class="stat-label">Private Institutions</div>
                </div>
                <div class="stat-card">
                    <div class="stat-num">{{ number_format($stats['total_scholarships']) }}</div>
                    <div class="stat-label">Scholarship Programs</div>
                </div>
                <div class="stat-card">
                    <div class="stat-num">{{ number_format($stats['total_course_offerings']) }}</div>
                    <div class="stat-label">Course Offerings</div>
                </div>
            </div>
        @endif

        {{-- Feature cards --}}
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px;margin-bottom:60px"
            class="fade-up fade-up-d2">

            <a href="{{ route('universities', ['free' => 1]) }}" class="u-card" style="background:#57e089">
                <div style="font-size:2rem"><i class="bi bi-mortarboard"></i></div>
                <div class="u-card-name">Free Tuition Schools</div>
                <p style="font-size:.85rem">All State Universities and Local Colleges offering free tuition under RA 10931.
                </p>
                <div style="color:var(--green);font-size:.83rem;font-weight:600">Browse SUC &amp; LUC →</div>
            </a>

            <a href="{{ route('courses', ['board' => 1]) }}" class="u-card" style="background:#f87979">
                <div style="font-size:2rem"><i class="bi bi-journal-text"></i></div>
                <div class="u-card-name">Board Exam Programs</div>
                <p style="font-size:.85rem">Courses that require PRC licensure — Nursing, Engineering, Medicine,
                    Architecture, and more.</p>
                <div style="color:#e63c3c;font-size:.83rem;font-weight:600">Find PRC programs →</div>
            </a>

            <a href="{{ route('regions') }}" class="u-card" style="background:#ba95f9">
                <div style="font-size:2rem">🗺</div>
                <div class="u-card-name">Regional Distribution</div>
                <p style="font-size:.85rem">Explore the distribution of HEIs across all 17 regions from NCR to BARMM.</p>
                <div style="color:var(--accent);font-size:.83rem;font-weight:600">View all regions →</div>
            </a>

        </div>
    </div>
@endsection
