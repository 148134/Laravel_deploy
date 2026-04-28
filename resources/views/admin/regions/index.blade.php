@extends('admin.layouts.app')
@section('title', 'Regions & Provinces')

@section('content')
<div class="page-header">
  <div class="breadcrumb">admin / <span>regions</span></div>
  <h1>Regions & Provinces</h1>
  <p>Reference data for the 17 regions and provinces. Edit via database migrations for structural changes.</p>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">
      All Regions
      <span class="count-badge">{{ $regions->count() }}</span>
    </div>
  </div>

  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>ID</th><th>Code</th><th>Region Name</th><th>Provinces</th></tr>
      </thead>
      <tbody>
        @foreach($regions as $r)
        <tr>
          <td><span class="mono-id">{{ $r->region_id }}</span></td>
          <td><span class="badge badge-blue">{{ $r->region_code }}</span></td>
          <td>{{ $r->region_name }}</td>
          <td style="font-size:.78rem;color:var(--text2)">
            {{ $provinces->get($r->region_id, collect())->pluck('province_name')->join(', ') ?: '—' }}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
