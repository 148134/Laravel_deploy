@extends('admin.layouts.app')
@section('title', 'Universities')

@section('content')
<div class="page-header">
  <div class="breadcrumb">admin / <span>universities</span></div>
  <h1>Universities</h1>
  <p>Manage CHED-accredited higher education institutions.</p>
</div>

{{-- Filter Bar --}}
<div class="filter-bar-wrap">
  <form method="GET" action="{{ route('admin.universities.index') }}" class="filter-bar">
    <div class="form-group">
      <label>Search</label>
      <input type="text" name="q" value="{{ request('q') }}" placeholder="Name, abbreviation, city...">
    </div>
    <div class="form-group">
      <label>Type</label>
      <select name="type_id">
        <option value="">All Types</option>
        @foreach($univTypes as $t)
          <option value="{{ $t->type_id }}" {{ request('type_id') == $t->type_id ? 'selected' : '' }}>
            {{ $t->type_code }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label>Region</label>
      <select name="region_id">
        <option value="">All Regions</option>
        @foreach($regions as $r)
          <option value="{{ $r->region_id }}" {{ request('region_id') == $r->region_id ? 'selected' : '' }}>
            {{ $r->region_code }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label>Status</label>
      <select name="active">
        <option value="">All</option>
        <option value="1" {{ request('active') === '1' ? 'selected' : '' }}>Active</option>
        <option value="0" {{ request('active') === '0' ? 'selected' : '' }}>Inactive</option>
      </select>
    </div>
    <div class="form-group" style="justify-content:flex-end;padding-top:18px">
      <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search"></i> Filter</button>
    </div>
  </form>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">
      University List
      <span class="count-badge">{{ $universities->count() }}</span>
    </div>
    <a href="{{ route('admin.universities.create') }}" class="btn btn-primary btn-sm">
      <i class="bi bi-plus-lg"></i> Add New
    </a>
  </div>

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>ID</th><th>Name</th><th>Type</th><th>Location</th>
          <th>Region</th><th>Accreditation</th><th>Status</th><th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($universities as $u)
        <tr>
          <td><span class="mono-id">{{ $u->university_id }}</span></td>
          <td>
            <strong>{{ $u->university_name }}</strong>
            @if($u->abbreviation)
              <br><span class="mono-muted">{{ $u->abbreviation }}</span>
            @endif
          </td>
          <td>
            @if($u->type)
              <span class="badge badge-blue">{{ $u->type->type_code }}</span>
            @else
              <span class="badge badge-gray">—</span>
            @endif
          </td>
          <td>
            {{ $u->city }}{{ $u->province ? ', '.$u->province->province_name : '' }}
          </td>
          <td>{{ optional($u->province?->region)->region_code ?? '—' }}</td>
          <td><span style="font-size:.78rem">{{ optional($u->accreditation)->level_name ?? '—' }}</span></td>
          <td>
            @if($u->is_active)
              <span class="badge badge-green">Active</span>
            @else
              <span class="badge badge-red">Inactive</span>
            @endif
          </td>
          <td>
            <div class="td-actions">
              <a href="{{ route('admin.universities.edit', $u->university_id) }}"
                 class="btn btn-secondary btn-xs">
                <i class="bi bi-pencil"></i> Edit
              </a>
              <a href="{{ route('admin.tuition.edit', $u->university_id) }}"
                 class="btn btn-success btn-xs" title="Edit Tuition &amp; Fees">
                <i class="bi bi-cash-coin"></i> Fees
              </a>

              {{-- Toggle --}}
              <form method="POST"
                    action="{{ route('admin.universities.toggle', $u->university_id) }}"
                    onsubmit="return confirm('Toggle status?')">
                @csrf @method('PATCH')
                <button type="submit"
                        class="btn btn-xs {{ $u->is_active ? 'btn-danger' : 'btn-success' }}">
                  {{ $u->is_active ? 'Deactivate' : 'Activate' }}
                </button>
              </form>

              {{-- Delete --}}
              <form method="POST"
                    action="{{ route('admin.universities.destroy', $u->university_id) }}"
                    onsubmit="return confirm('Permanently delete this university and all related records?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-xs">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8"><div class="empty-state">No universities found.</div></td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
