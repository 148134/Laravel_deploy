@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="page-header">
  <div class="breadcrumb">admin / <span>dashboard</span></div>
  <h1>Dashboard</h1>
  <p>Overview of the Philippines Education database.</p>
</div>

<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-label">Total HEIs</div>
    <div class="stat-value blue">{{ number_format($stats['total_unis']) }}</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Active</div>
    <div class="stat-value green">{{ number_format($stats['active_unis']) }}</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Inactive</div>
    <div class="stat-value red">{{ number_format($stats['inactive_unis']) }}</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Courses</div>
    <div class="stat-value">{{ number_format($stats['total_courses']) }}</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Scholarships</div>
    <div class="stat-value">{{ number_format($stats['total_schols']) }}</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Regions</div>
    <div class="stat-value">{{ number_format($stats['total_regions']) }}</div>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title"><i class="bi bi-clock-history"></i> Recently Added Universities</div>
    <a href="{{ route('admin.universities.create') }}" class="btn btn-primary btn-sm">
      <i class="bi bi-plus-lg"></i> Add New
    </a>
  </div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>Name</th><th>City</th><th>Year Established</th></tr>
      </thead>
      <tbody>
        @forelse($recentUnis as $u)
        <tr>
          <td>{{ $u->university_name }}</td>
          <td>{{ $u->city ?? '—' }}</td>
          <td>{{ $u->year_established ?? '—' }}</td>
        </tr>
        @empty
        <tr><td colspan="3"><div class="empty-state">No universities yet.</div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px">
  <a href="{{ route('admin.universities.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-lg"></i> Add University
  </a>
  <a href="{{ route('admin.courses.create') }}" class="btn btn-secondary">
    <i class="bi bi-plus-lg"></i> Add Course
  </a>
  <a href="{{ route('admin.scholarships.create') }}" class="btn btn-secondary">
    <i class="bi bi-plus-lg"></i> Add Scholarship
  </a>
</div>
@endsection
